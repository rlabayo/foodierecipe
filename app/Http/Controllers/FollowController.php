<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\Profile;
use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Models\User;

class FollowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function follower(Request $request)
    {
        $user_id = $request->id != NULL ? $request->id : auth()->user()->id;
        $profile = Profile::where('user_id', '=', $user_id)->get();
        $user = User::find($user_id);

        $followers = Follow::where('follow', $user_id)->get(); 

        foreach($followers as $key=>$value){
            $profile_details = Profile::select('profiles.user_id', 'profiles.image', 'profiles.thumbnail', 'profiles.description', 'users.name', 'users.email')->join('users', 'profiles.user_id', '=', 'users.id')->where('user_id',$value['user_id'])->get()->toArray()[0];

            $followers[$key]['image'] = $profile_details['image'];
            $followers[$key]['thumbnail'] = $profile_details['thumbnail'];
            $followers[$key]['description'] = $profile_details['description'];
            $followers[$key]['name'] = $profile_details['name'];
            $followers[$key]['email'] = $profile_details['email'];
            $followers[$key]['follower_id'] = $value['user_id'];
            
        }
        
        return view('web.follower.index', [
            'user' => $user,
            'profile' => $profile[0],
            'followers' => $followers,
            'total_favorite' => $user->favorite()->get()->count(),
            'total_post' => Recipe::where('user_id', $user_id)->count(),
            'total_follower' => Follow::where('follow', $user_id)->count(),
            'total_following' => Follow::where('user_id', $user_id)->count(),
        ]);
    }

    public function following(Request $request)
    {
        $user_id = $request->id != NULL ? $request->id : auth()->user()->id;
        $profile = Profile::where('user_id', '=', $user_id)->get();

        $user = User::find($user_id);

        $following = Follow::where('user_id', $user_id)->get(); 
        
        foreach($following as $key=>$value){
            $profile_details = Profile::select('profiles.user_id', 'profiles.image', 'profiles.thumbnail', 'profiles.description', 'users.name', 'users.email')->join('users', 'profiles.user_id', '=', 'users.id')->where('user_id',$value['follow'])->get()->toArray()[0];
            
            $following[$key]['image'] = $profile_details['image'];
            $following[$key]['thumbnail'] = $profile_details['thumbnail'];
            $following[$key]['description'] = $profile_details['description'];
            $following[$key]['name'] = $profile_details['name'];
            $following[$key]['email'] = $profile_details['email'];
            $following[$key]['following_id'] = $value['follow'];
        }
        

        return view('web.following.index', [
            'user' => $user,
            'profile' => $profile[0],
            'following' => $following,
            'total_favorite' => $user->favorite()->get()->count(),
            'total_post' => Recipe::where('user_id', $user_id)->count(),
            'total_follower' => Follow::where('follow', $user_id)->count(),
            'total_following' => Follow::where('user_id', $user_id)->count(),
        ]);
    }

    public function follow(Request $request){
        Follow::create([
            'follow' => $request->id,
            'user_id' => auth()->user()->id
        ]);

        return redirect(route('profile.index', $request->id));
    }

    public function unfollow(Request $request){
        $follow = Follow::where([
                    ['user_id', '=', auth()->user()->id],
                    ['follow', '=', $request->id],
                ]);
        $follow->delete();

        return redirect(route('profile.index', $request->id));
    }

    public function removeFollower(Request $request){
        $follow = Follow::where([
            ['user_id', '=', $request->id],
            ['follow', '=', auth()->user()->id]
        ]);
        $follow->delete();

        return redirect(route('profile.index', auth()->user()->id));
    }
}
