<?php

namespace App\Http\Controllers;

use App\Enums\Unit;
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
            ->where('id', '<>', $id)
            ->where('private', '<>', '1')
            ->limit(5)->get();

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
