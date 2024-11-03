<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request){ 
        // Set custom url path for show recipe back button
        session(['customPrevURL' => parse_url(url()->current(), PHP_URL_PATH)]);

        // Check search item if it does exist in session
        // if searchItem exist, use it as the param 
        // otherwise update session item for searchItem by the given search keyword.
        if(session('searchItem') && $request->search == ""){
            $param = session('searchItem');
        }else {
            session(['searchItem' => $request->search]);
            $param = $request->search;
        }
        
        if($param != null || $param != ""){
            $profile_items = User::join('profiles', 'users.id', '=', 'profiles.user_id')
                        ->select('users.name', 'profiles.user_id AS user_id', 'profiles.id as profile_id', 'profiles.image AS profile_image', 'users.email', 'profiles.description')
                        ->where('users.name', 'LIKE', "%$param%")
                        ->get();
                      
            $items = Recipe::select('recipes.*', 'profiles.image AS profile_image')
                        ->leftJoin('profiles', 'recipes.user_id', '=', 'profiles.user_id')
                        ->join('users', 'users.id', '=', 'profiles.user_id' )
                        ->where('title', 'like', '%' . $param . '%')
                        ->orWhere('ingredients', 'like', '%' . $param . '%')
                        ->orWhere('users.name', 'like', '%' . $param . '%')
                        ->where('recipes.private', '=', 0)
                        ->latest()
                        ->get();
                        
            // check if the recipes are user's favorites
            if(Auth::check()){
                $items = Recipe::select('recipes.*', 'profiles.image AS profile_image')
                        ->leftJoin('profiles', 'recipes.user_id', '=', 'profiles.user_id')
                        ->join('users', 'users.id', '=', 'profiles.user_id' )
                        ->where('title', 'like', '%' . $param . '%')
                        ->orWhere('ingredients', 'like', '%' . $param . '%')
                        ->orWhere('users.name', 'like', '%' . $param . '%')
                        ->latest()
                        ->get();

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
            }
            
            return view('web.search.all_category_results', compact('items', 'profile_items', 'param'));
        }else{
            return back();
        }
    }

    public function get_recipes(Request $request){
        $param = $request->param;
        
        if($param != null || $param != ""){
            if(Auth::check()){
                $total_items = Recipe::select('recipes.*', 'profiles.image AS profile_image')
                            ->leftJoin('profiles', 'recipes.user_id', '=', 'profiles.user_id')
                            ->join('users', 'users.id', '=', 'profiles.user_id' )
                            ->where('title', 'like', '%' . $param . '%')
                            ->orWhere('ingredients', 'like', '%' . $param . '%')
                            ->orWhere('users.name', 'like', '%' . $param . '%')
                            ->count();

                $items = Recipe::select('recipes.*', 'profiles.image AS profile_image')
                            ->leftJoin('profiles', 'recipes.user_id', '=', 'profiles.user_id')
                            ->join('users', 'users.id', '=', 'profiles.user_id' )
                            ->where('title', 'like', '%' . $param . '%')
                            ->orWhere('ingredients', 'like', '%' . $param . '%')
                            ->orWhere('users.name', 'like', '%' . $param . '%')
                            ->latest()
                            ->paginate(6);

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
            }else{
                $total_items = Recipe::select('recipes.*', 'profiles.image AS profile_image')
                            ->leftJoin('profiles', 'recipes.user_id', '=', 'profiles.user_id')
                            ->join('users', 'users.id', '=', 'profiles.user_id' )
                            ->where('title', 'like', '%' . $param . '%')
                            ->orWhere('ingredients', 'like', '%' . $param . '%')
                            ->orWhere('users.name', 'like', '%' . $param . '%')
                            ->where('recipes.private', '=', 0)
                            ->count();
                            
                $items = Recipe::select('recipes.*', 'profiles.image AS profile_image')
                        ->leftJoin('profiles', 'recipes.user_id', '=', 'profiles.user_id')
                        ->join('users', 'users.id', '=', 'profiles.user_id' )
                        ->where('title', 'like', '%' . $param . '%')
                        ->orWhere('ingredients', 'like', '%' . $param . '%')
                        ->orWhere('users.name', 'like', '%' . $param . '%')
                        ->where('recipes.private', '=', 0)
                        ->latest()
                            ->paginate(6);
            }
            
            
            return view('web.search.recipe_results', compact('items', 'total_items', 'param'));
        }else{
            return back();
        }
    }

    public function get_profiles(Request $request){
        $param = $request->param;
        if($param != null || $param != ""){
            $total_profile_items = User::join('profiles', 'users.id', '=', 'profiles.user_id')
                        ->select('users.name', 'profiles.user_id AS user_id', 'profiles.id as profile_id', 'profiles.image AS profile_image', 'users.email', 'profiles.description')
                        ->where('users.name', 'LIKE', "%$param%")
                        ->get()->count();
                    
            $profile_items = User::join('profiles', 'users.id', '=', 'profiles.user_id')
                        ->select('users.name', 'profiles.user_id AS user_id', 'profiles.id as profile_id', 'profiles.image AS profile_image', 'users.email', 'profiles.description')
                        ->where('users.name', 'LIKE', "%$param%")
                        ->paginate(6);
                 
            return view('web.search.profile_results', compact('profile_items', 'total_profile_items', 'param'));
        }else{
            return back();
        }
    }
}
