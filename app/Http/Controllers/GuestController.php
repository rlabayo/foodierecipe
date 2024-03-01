<?php

namespace App\Http\Controllers;

use App\Enums\Unit;
use App\Libraries\CommonLibrary;
use App\Models\Profile;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;

class GuestController extends Controller
{
    public function index(){
        // Display all public recipes
        $recipe = new Recipe();
        $items = $recipe->get_public_recipes();

        return view('web.guest.index', compact('items'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Recipe $recipe, $id)
    {
        $unit = Unit::cases();
        $recipe = $recipe::find($id);

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
        return view('web.guest.show', compact('recipe', 'unit', 'comments', 'total_comments', 'recommendation_list'));
    }
}
