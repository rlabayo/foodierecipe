<?php

namespace App\Http\Controllers;

use App\Libraries\CommonLibrary;
use App\Models\Profile;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;

class GuestController extends Controller
{
    public $recipe_model;

    public function __construct()
    {
        $this->recipe_model = new Recipe();
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
        $recipe = $recipe::where(['id'=>$id, 'private'=>0])->get();
        
        // check if the recipe is available
        if($recipe->count() > 0){
            $recipe = $recipe[0];
            $exploded_title = explode(' ', $recipe->title);
        
            // get recommendation list
            $common = new CommonLibrary();
            $recommendation_list = $common->get_recommendation($id, $exploded_title);
    
            // get comments
            $comments = Recipe::find($id)->comments()->latest()->paginate(5);
            $total_comments = Recipe::find($id)->comments()->count();
            
            foreach($comments as $key => $comment){
                $comments[$key]->profile_thumbnail = Profile::find(['user_id', $comment->user_id])[0]->image;
                $comments[$key]->profile_name = User::select('name')->where('id', $comment->user_id)->get()[0]->name;
            }

            return view('web.guest.show', compact('recipe', 'comments', 'total_comments', 'recommendation_list'));
        }
        
        // display error 404
        return redirect('/recipe/error/404');
    }
}
