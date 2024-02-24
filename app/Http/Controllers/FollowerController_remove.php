<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\Profile;
use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Models\User;

class FollowerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $profile = Profile::where('user_id', '=', auth()->user()->id)->get();
        $recipes = Recipe::where('user_id', auth()->user()->id)->latest()->get();

        $user = User::find(auth()->user()->id);
        $favorite_list = $user->favorite()->get();

        return view('web.follower.index', [
            'user' => $request->user(),
            'profile' => $profile[0],
            'recipes' => $recipes,
            'favorites' => $favorite_list,
            'total_favorite' => $user->favorite()->get()->count(),
            'total_post' => Recipe::where('user_id', $request->user()->id)->count(),
            'total_follower' => Follow::where('follow', $request->user()->id)->count(),
            'total_following' => Follow::where('user_id', $request->user()->id)->count(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Follow $follow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Follow $follow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Follow $follow)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Follow $follow)
    {
        //
    }
}
