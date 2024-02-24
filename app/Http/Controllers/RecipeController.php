<?php

namespace App\Http\Controllers;

use App\Enums\Boolean;
use App\Enums\Unit;
use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Libraries\ImageLibrary;
use App\Logging\CustomFile;
use App\Models\Comment;
use App\Models\Favorite;
use App\Models\Profile;
use App\Models\Recipe;
use Exception;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\File as HttpFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Enum;
use Throwable;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Database\Query\Builder;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $recipe = new Recipe();
        $items = $recipe->get_all_recipes();
        
        return view('web.recipe.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $units = Unit::cases();
        $boolean = Boolean::cases();
        // dd($units);
        return view('web.recipe.create', compact('units', 'boolean'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    public function store(StoreRecipeRequest $request)
    {
        try{
            $validated = $request->validated();
            $user_id = auth()->user()->id;
            $image_banner = "";
            $image_thumbnail = "";
            
            $imageLibrary = new ImageLibrary(); 
            
            if($request->hasFile('image')){
                // $image_banner = $imageLibrary->createImage($request->file('attachment_hidden_image'), 1435, 559, 'uploads/recipes/user_' .auth()->user()->id. '/banner/');
                // $image_thumbnail = $imageLibrary->createImage($request->file('image'), 400, 300, 'uploads/recipes/user_' .auth()->user()->id. '/thumbnail/');
                $image_banner = $imageLibrary->createImageFromBase64Image($request->attachment_banner, 1435, 559, 'uploads/recipes/user_' .auth()->user()->id. '/banner/');
                $image_thumbnail = $imageLibrary->createImageFromBase64Image($request->attachment_thumbnail, 400, 300, 'uploads/recipes/user_' .auth()->user()->id. '/thumbnail/');
            }
            $instructions = json_decode($validated['instruction']);
            
            foreach($instructions as $key => $instruction){
                $base64_photo = $instruction->attached_photo;
                if($base64_photo != '' && $base64_photo != 'undefined'){
                    $attached = $imageLibrary->createImageFromBase64Image($base64_photo, 400, 300, 'uploads/recipes/user_' .auth()->user()->id. '/instruction/');
                    $instructions[$key]->attached_photo = $attached;
                }else {
                    $instructions[$key]->attached_photo = '';
                }
            }

            Recipe::create([
                'user_id' => $user_id,
                'title' => $validated['title'],
                'summary' => $validated['summary'],
                'ingredients' => $validated['ingredients'],
                'instruction' => json_encode($instructions),
                'video_url' => $validated['video_url'],
                'private' => $validated['private'],
                'image' => $image_banner,
                'thumbnail' => $image_thumbnail
            ]);

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
     * Display the specified resource.
     */
    public function show(Recipe $recipe, $id)
    {
        $unit = Unit::cases();
        
        $recipe = DB::table('recipes')
                ->select('recipes.*')
                ->selectRaw('favorites.id as favorite_id, (CASE WHEN favorites.id IS NULL then 0 else 1 END) AS is_favorite')
                ->leftJoin('favorites', 'recipes.id' , '=', 'favorites.recipe_id')
                ->where('recipes.id', '=', $id)
                ->get()[0];
                
        // get recommendation list
        $exploded_title = explode(' ', $recipe->title);
        $recipe_id = $recipe->id;

        $recommendation_list = DB::table('recipes')->select('id', 'title')
            ->orWhere(function (Builder $query) use($exploded_title) {
                foreach($exploded_title as $key => $element) {
                    if($key == 0) {
                        $query->where('title', 'like', '%'.$element.'%')
                            ->orwhere('ingredients', 'like', '%'.$element.'%');
                    }
                        $query->orWhere('title', 'like', '%'.$element.'%')
                            ->orwhere('ingredients', 'like', '%'.$element.'%');
                }
            })
            ->where('id', '<>', $recipe_id)
            ->limit(5)->get();

        // get comments
        $comments = Recipe::find($id)->comments()->latest()->paginate(5);
        $total_comments = Recipe::find($id)->comments()->count();

        foreach($comments as $key => $comment){
            $comments[$key]->profile_thumbnail = Profile::find(['user_id', $comment->user_id])[0]->image;
            $comments[$key]->profile_name = User::select('name')->where('id', $comment->user_id)->get()[0]->name;
        }

        return view('web.recipe.show', compact('recipe', 'unit', 'comments', 'total_comments', 'recommendation_list'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recipe $recipe, $id)
    {
        $units = Unit::cases();
        $boolean = Boolean::cases();
        $item = Recipe::find($id);
        
        return view('web.recipe.edit', ['recipe' => $item, 'boolean' => $boolean]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRecipeRequest $request, Recipe $recipe)
    {
        try{
            $recipe = Recipe::find($request->id);
            $validated = $request->validated();
            $imageLibrary = new ImageLibrary(); 

            $old_image = $recipe->image;
            $old_thumbnail = $recipe->thumbnail;

            $image_banner = $old_image;
            $image_thumbnail = $old_thumbnail;
            
            // banner
            if($request->hasFile('image')){
                // get the existing image filepath and remove
                if(Storage::disk('public')->exists($old_image)){
                    Storage::disk('public')->delete($old_image);
                }
                if(Storage::disk('public')->exists($old_thumbnail)){
                    Storage::disk('public')->delete($old_thumbnail);
                }
                
                // $image_banner = $imageLibrary->createImage($request->file('attachment_hidden_image'), 1435, 559, 'uploads/recipes/user_' .auth()->user()->id. '/banner/');
                // $image_thumbnail = $imageLibrary->createImage($request->file('image'), 400, 300, 'uploads/recipes/user_' .auth()->user()->id. '/thumbnail/');

                $image_banner = $imageLibrary->createImageFromBase64Image($request->attachment_banner, 1435, 559, 'uploads/recipes/user_' .auth()->user()->id. '/banner/');
                $image_thumbnail = $imageLibrary->createImageFromBase64Image($request->attachment_thumbnail, 400, 300, 'uploads/recipes/user_' .auth()->user()->id. '/thumbnail/');

                // ($image_banner == false) && throw new Exception('Please try to upload image again with maximum of 2mb.');
            }
            $instructions = json_decode($validated['instruction']);
                
            // get the image list of old and new instruction
            $new_image_list = array_map(function($item){
                return $item['attached_photo'];
            }, json_decode($validated['instruction'], true));

            $old_image_list = array_map(function($item){
                return $item['attached_photo'];
            }, json_decode($recipe->instruction, true));

            // remove deleted images from storage
            $this->remove_image_from_storage($old_image_list, $new_image_list);

            foreach($instructions as $key => $instruction){
                $base64_photo = $instruction->attached_photo;
                if($base64_photo != '' && $base64_photo != 'undefined'){
                    if(str_contains($base64_photo, 'uploads/recipes')){
                        // retain image
                    }else{
                        $attached = $imageLibrary->createImageFromBase64Image($base64_photo, 400, 300, 'uploads/recipes/user_' .auth()->user()->id. '/instruction/');
                        $instructions[$key]->attached_photo = $attached;
                    }
                }else {
                    $instructions[$key]->attached_photo = '';
                }
            }
            $recipe->update([
                'title' => $validated['title'],
                'summary' => $validated['summary'],
                'ingredients' => $validated['ingredients'],
                'instruction' => json_encode($instructions),
                'video_url' => $validated['video_url'],
                'private' => $validated['private'],
                'image' => $image_banner,
                'thumbnail' => $image_thumbnail
            ]);

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
            
            // get the recipe details
            $recipe = Recipe::find($request->id);

            $banner = $recipe->image;
            $thumbnail = $recipe->thumbnail;

            // remove banner image
            $this->remove_recipe_images_from_storage((array)$banner);
            // remove thumbnail image
            $this->remove_recipe_images_from_storage((array)$thumbnail);

            $image_list = array_map(function($item){
                return $item['attached_photo'];
            }, json_decode($recipe->instruction, true));

            // remove deleted images from storage
            $this->remove_recipe_images_from_storage($image_list);

            $recipe->delete();
            
            return back()->with('status', 201);

        }catch(Throwable $e){
            // Call in controller
            CustomFile::index('RecipeController', 'error', [
                'message' => ['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()],
            ]);
            
            return back()->withInput()->with('status', 400);
        }
    }

    public function remove_recipe_images_from_storage($list){
        if(count($list) > 0){
            array_map(function($image){
                // delete image
                if(Storage::disk('public')->exists($image)){
                    Storage::disk('public')->delete($image);
                }
            }, $list);
        }
        return;
    }

    // compare old instruction list to new instruction
    public function remove_image_from_storage($old_list, $new_list){
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
                        if(Storage::disk('public')->exists($image)){
                            Storage::disk('public')->delete($image);
                        }
                    }
                }
            }
        }, $old_list);
    }

}
