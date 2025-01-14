<?php

namespace App\Http\Controllers;

use App\Libraries\CommonLibrary;
use App\Logging\CustomFile;
use App\Models\Profile;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use Throwable;

class GuestController extends Controller
{
    public $recipe_model;
    public $common_library;

    public function __construct()
    {
        $this->recipe_model = new Recipe();
        $this->common_library = new CommonLibrary();
    }
    /**
     * Display a list of all public recipes
     */
    public function index(){
        // Set custom url path for show recipe back button
        session(['customPrevURL' => parse_url('/', PHP_URL_PATH)]);
        
        $items = $this->recipe_model->get_public_recipes();
        
        return view('web.guest.index', compact('items'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Recipe $recipe, $id)
    {
        try{
            $decrypted_result = $this->common_library->decrypt_id($id);
            $decrypted_id = $decrypted_result['status'] != false ? $decrypted_result['id'] : throw new \Exception("Encrypted ID is corrupted.");

            $recipe = $recipe::where(['id'=>$decrypted_id, 'private'=>0])->get();
        
            // check if the recipe is available for guest user
            if($recipe->count() > 0){
                $recipe = $recipe[0];
                $exploded_title = explode(' ', $recipe->title);
            
                // get recommendation list
                $common = new CommonLibrary();
                $recommendation_list = $common->get_recommendation($decrypted_id, $exploded_title);
        
                // get comments
                $comments = Recipe::find($decrypted_id)->comments()->latest()->paginate(5);
                $total_comments = Recipe::find($decrypted_id)->comments()->count();
                
                foreach($comments as $key => $comment){
                    $comments[$key]->profile_thumbnail = Profile::find(['user_id', $comment->user_id])[0]->image;
                    $comments[$key]->profile_name = User::select('name')->where('id', $comment->user_id)->get()[0]->name;
                }

                return view('web.guest.show', compact('recipe', 'comments', 'total_comments', 'recommendation_list'));
            }else {
                // if the recipe is not public, the user needs to log in to view the recipe
                return redirect(route("recipe.show", $id));
            }
        }catch(Throwable $e){
            CustomFile::index("GuestController", "error", [
                "message" => ["message" => $e->getMessage(), "file" => $e->getFile(), "line" => $e->getLine()]
            ]);

            return redirect('/recipe/error/404');
        }
    }
}
