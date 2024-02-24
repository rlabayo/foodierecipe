<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Recipe;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request){
        $param = $request->search;
        if($param != null || $param != ""){
            $items = Recipe::select('recipes.*', 'profiles.image AS profile_image')
                        ->leftJoin('profiles', 'recipes.user_id', '=', 'profiles.user_id')
                        ->join('users', 'users.id', '=', 'profiles.user_id' )
                        ->where('title', 'like', '%' . $param . '%')
                        ->orWhere('ingredients', 'like', '%' . $param . '%')
                        ->orWhere('users.name', 'like', '%' . $param . '%')
                        ->latest()->paginate(5);

            // check if the recipes are user's favorites
            foreach($items as $key => $item){
                $favorite_model = new Favorite();
                $favorite_result = $favorite_model->is_favorite(auth()->user()->id, $item['id']);
                
                // if recipe is a favorite of the current user
                if($favorite_result != false){
                    $items[$key]->favorite_id = $favorite_result[0]->favorite_id;
                    $items[$key]->is_favorite = 1;
                    $items[$key]->favorite_by = $favorite_result[0]->favorite_by;
                }
            }
            return view('web.search_results', compact('items'));
        }else{
            return back();
        }
    }
}
