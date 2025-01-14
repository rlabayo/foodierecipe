<?php

namespace App\Http\Controllers;

use App\Enums\Boolean;
use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Libraries\CommonLibrary;
use App\Libraries\ImageLibrary;
use App\Logging\CustomFile;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Throwable;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class RecipeController extends Controller
{
    public $image_library;
    public $common_library;
    public $comment_controller;
    public $recipe_model;
    
    public function __construct()
    {
        // Library
        $this->image_library = new ImageLibrary(); 
        $this->common_library = new CommonLibrary();

        // Controller
        $this->comment_controller = new CommentController();

        // Model
        $this->recipe_model = new Recipe();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $boolean = Boolean::cases();

        return view('web.recipe.create', compact('boolean'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRecipeRequest $request)
    {
        try{
            DB::beginTransaction();

                $validated = $request->validated();
                $user_id = auth()->user()->id;
                $image_banner = "";
                $image_thumbnail = "";
                
                if($request->hasFile('image')){
                    // Upload images to storage and get the image path name
                    $image_banner = $this->image_library->createImageFromBase64Image($request->attachment_banner, 'uploads/recipes/user_' .auth()->user()->id. '/banner/', 1200);
                    $image_thumbnail = $this->image_library->createImageFromBase64Image($request->attachment_thumbnail, 'uploads/recipes/user_' .auth()->user()->id. '/thumbnail/');
                }

                // upload images and update the json instruction data with the image path name
                $instructions = $this->instructions_upload_images(json_decode($validated['instruction']));

                Recipe::create([
                    'user_id' => $user_id,
                    'title' => $validated['title'],
                    'summary' => $validated['summary'],
                    'ingredients' => $validated['ingredients'],
                    'instruction' => json_encode($instructions),
                    'video_url' => $validated['video_url'],
                    'private' => $validated['private'],
                    'is_draft' => $validated['is_draft'],
                    'image' => $image_banner,
                    'thumbnail' => $image_thumbnail
                ]);

            DB::commit();

            return back()->with('status', 201);

        }catch(Throwable $e){
            DB::rollBack();

            // Call in controller to create or update the error file
            CustomFile::index('RecipeController', 'error', [
                'message' => ['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()],
            ]);
            
            return back()->withInput()->with('status', 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Recipe $recipe, $id)
    { 
        try{
            $decrypted_result = $this->common_library->decrypt_id($id);

            $decrypted_id = $decrypted_result['status'] != false ? $decrypted_result['id'] : throw new \Exception("Encrypted ID is corrupted.");

            $recipe = $this->recipe_model->get_recipe_details($decrypted_id);
            
            // check if the recipe is available
            if($recipe->count() > 0){
                $recipe = $recipe[0];
                // get array of exploded title
                $exploded_title = explode(' ', $recipe->title);
                // get recommendation list
                $recommendation_list = $this->common_library->get_recommendation($recipe->id, $exploded_title);

                // get comments
                $comments = $this->comment_controller->get_comments_by_user_id($decrypted_id);
                $total_comments = Recipe::find($decrypted_id)->comments()->count();
                
                return view('web.recipe.show', compact('recipe', 'comments', 'total_comments', 'recommendation_list'));
            }
            
            // display error 404
            return redirect('/recipe/error/404');
                
        }catch(Throwable $e){
            // Create or update the log file for error
            CustomFile::index('RecipeController', 'error', [
                'message' => ['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()],
            ]);

            // display error 404
            return redirect('/recipe/error/404');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recipe $recipe, $id)
    {
        try{
            $decrypted_result = $this->common_library->decrypt_id($id);
            $decrypted_id = $decrypted_result['status'] != false ? $decrypted_result['id'] : throw new \Exception("Encrypted ID is corrupted.");

            $boolean = Boolean::cases();
            $item = Recipe::find($decrypted_id);
            
            return view('web.recipe.edit', ['recipe' => $item, 'boolean' => $boolean]);

        }catch(Throwable $e){
            CustomFile::index('RecipeController', 'error', [
                'message' => ['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()]
            ]);

            return redirect('profile');
        }
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRecipeRequest $request, Recipe $recipe)
    {
        try{
            $decrypted_result = $this->common_library->decrypt_id($request->id);
            $decrypted_id = $decrypted_result['status'] != false ? $decrypted_result['id'] : throw new \Exception("Encrypted ID is corrupted.");

            DB::beginTransaction();

                $recipe = Recipe::find($decrypted_id);
                $validated = $request->validated();

                $old_image = $recipe->image;
                $old_thumbnail = $recipe->thumbnail;

                $image_banner = $old_image;
                $image_thumbnail = $old_thumbnail;
                
                // banner
                if($request->hasFile('image')){
                    // get the existing image filepath and remove
                    // image / banner
                    $this->image_library->delete_stored_image($old_image);
                    // thumbnail
                    $this->image_library->delete_stored_image($old_thumbnail);
                    
                    $image_banner = $this->image_library->createImageFromBase64Image($request->attachment_banner, 'uploads/recipes/user_' .auth()->user()->id. '/banner/', 1200);
                    $image_thumbnail = $this->image_library->createImageFromBase64Image($request->attachment_thumbnail, 'uploads/recipes/user_' .auth()->user()->id. '/thumbnail/');

                }
                // get the image list of old and new instruction
                $new_image_list = $this->get_image_list_from_json_data($validated['instruction']);
                $old_image_list = $this->get_image_list_from_json_data($recipe->instruction);

                // remove deleted images from storage
                $this->remove_old_image_from_storage($old_image_list, $new_image_list);

                // upload images and update the json instruction data with the image path name
                $instructions = $this->instructions_upload_images(json_decode($validated['instruction']));

                $recipe->update([
                    'title' => $validated['title'],
                    'summary' => $validated['summary'],
                    'ingredients' => $validated['ingredients'],
                    'instruction' => json_encode($instructions),
                    'video_url' => $validated['video_url'],
                    'private' => $validated['private'],
                    'is_draft' => $validated['is_draft'],
                    'image' => $image_banner,
                    'thumbnail' => $image_thumbnail
                ]);
            
            DB::commit();

            return back()->with('status', 201);

        }catch(Throwable $e){
            // Call in controller
            CustomFile::index('RecipeController', 'error', [
                'message' => ['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()],
            ]);
            
            return back()->withInput()->with('status', 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Recipe $recipe)
    {
        try{
            $decrypted_result = $this->common_library->decrypt_id($request->id);
            $decrypted_id = $decrypted_result['status'] != false ? $decrypted_result['id'] : throw new \Exception("Encrypted ID is corrupted.");

            // get the recipe details
            $recipe = Recipe::find($decrypted_id);

            $banner = $recipe->image;
            $thumbnail = $recipe->thumbnail;

            // remove banner image
            $this->image_library->delete_stored_image($banner);
            // remove thumbnail image
            $this->image_library->delete_stored_image($thumbnail);

            $image_list = $this->get_image_list_from_json_data($recipe->instruction);

            // remove deleted images from storage
            $this->iterate_instruction_image_list($image_list);

            $recipe->delete();
            
            return redirect(route('profile.index'))->with('status', 200);

        }catch(Throwable $e){
            // Call in controller
            CustomFile::index('RecipeController', 'error', [
                'message' => ['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()],
            ]);
            
            return back()->with('status', 400);
        }
    }

    /**
     * Remove images
     */
    
    public function iterate_instruction_image_list($list){
        if(count($list) > 0){
            array_map(function($image){
                // delete image
                $this->image_library->delete_stored_image($image);
            }, $list);
        }
        return;
    }

     /**
     * Extract image field from the instructions
     */
    public function get_image_list_from_json_data($instruction){
        $image_list = array_map(function($item){
            return $item['attached_photo'];
        }, json_decode($instruction, true));

        return $image_list;
    }

     /**
     * Compare old instruction list to new instruction
     * and then remove old images if images was updated to the specific instruction
     */

    public function remove_old_image_from_storage($old_list, $new_list){
        array_map(function($image) use ($new_list){
            if($image != ''){
                $found = false; // set default found to false

                foreach($new_list as $key => $item){
                    if($image == $item){
                        $found = true;
                    }

                    // when done checking all the new image list and the old image is not found, delete the image from the public storage
                    if(count($new_list) == ($key+1) && $found == false){
                        // delete the image
                        $this->image_library->delete_stored_image($image);
                    }
                }
            }
        }, $old_list);
    }

    /**
     * Function to iterate json instructions to upload images
     */

     public function instructions_upload_images($instructions){

        foreach($instructions as $key => $instruction){
            $base64_photo = $instruction->attached_photo;
            if($base64_photo != '' && $base64_photo != 'undefined'){
                if(str_contains($base64_photo, 'uploads/recipes')){
                    // retain image for update 
                }else{
                    $attached = $this->image_library->createImageFromBase64Image($base64_photo, 'uploads/recipes/user_' .auth()->user()->id. '/instruction/', 400, 400);
                    $instructions[$key]->attached_photo = $attached;
                }
            }else {
                $instructions[$key]->attached_photo = '';
            }
        }

        return $instructions;
     }

}
