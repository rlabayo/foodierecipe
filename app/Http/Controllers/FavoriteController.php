<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Follow;
use App\Models\Profile;
use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class FavoriteController extends Controller
{
    public function index(Request $request): View 
    {
        $user_id = $request->id != NULL ? $request->id : auth()->user()->id;
        $profile = Profile::where('user_id', '=', $user_id)->get();
        $user = User::find($user_id); 
        
        return view('web.favorite.index', [
            'user' => $user,
            'profile' => $profile[0],
            'items' => $user->favorite()->get(),
            'total_favorite' => $user->favorite()->get()->count(),
            'total_post' => Recipe::where('user_id', $user_id)->count(),
            'total_follower' => Follow::where('follow', $user_id)->count(),
            'total_following' => Follow::where('user_id', $user_id)->count(),
        ]);
    }

    public function add(Request $request){
        
        $created_data = Favorite::create([
            'user_id' => auth()->user()->id,
            'recipe_id' => $request->id
        ]);

        if(!$created_data->id ){
            DB::rollBack();
        }else{
            DB::commit();
        }
        
        return back();

    }

    public function remove(Request $request) {
        
        $deleted_data = Favorite::where('id', $request->id)->delete();

        if(!$deleted_data) {
            DB::rollback();
        }else {
            DB::commit();
        }

        return back();
    }

    public function store(Request $request){
        Favorite::create([
            'user_id' => auth()->user()->id,
            'recipe_id' => $request->id
        ]);

        return redirect("recipe/$request->id");
    }

    public function check(Request $request) {
        echo "<pre>";
        $favorite = new Favorite;
        $is_favorite = $favorite->is_favorite(auth()->user()->id, $request->id);
        // $check = Favorite::where('user_id', auth()->user()->id)->where('recipe_id', $request->id)->first();

        if($is_favorite === false) {
            // Favorite::create([
            //     'user_id' => auth()->user()->id,
            //     'recipe_id' => $request->id
            // ]);
        }else {
            
        }
        // var_dump($check);
    }

    public function show(){
        
    }



}
