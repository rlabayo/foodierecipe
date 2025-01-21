<?php

namespace App\Http\Controllers;

use App\Libraries\CommonLibrary;
use App\Logging\CustomFile;
use App\Models\Follow;
use App\Models\Profile;
use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Throwable;

class FollowController extends Controller
{
    public $follow;
    public $common_library;

    public function __construct()
    {
        $this->follow = new Follow();
        $this->common_library = new CommonLibrary();
    }

    /**
     * Display a listing of the resource.
     */
    public function follower(Request $request)
    { 
        try{
            $decrypted_id = NULL;

            if($request->id != NULL){
                // Decrypt the given ID to check if it is valid
                $decrypted_result = $this->common_library->decrypt_id($request->id);
                $decrypted_id = $decrypted_result['status'] != false ? $decrypted_result['id'] : throw new \Exception("Encrypted ID is corrupted.");
            }
            
            $user_id = $decrypted_id != NULL ? $decrypted_id : auth()->user()->id;
            $profile = Profile::where('user_id', '=', $user_id)->get();
            $user = User::find($user_id);

            $followers = Follow::where('follow', $user_id)->get();

            foreach($followers as $key => $value){
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
                'is_follow' => $this->follow->is_follow(auth()->user()->id, $decrypted_id),
                'userType' => 'member'
            ]);
        }catch(Throwable $e){
            CustomFile::index("FollowController", "error", [
                "message" => [
                    "code" => $e->getCode(),
                    "message" => $e->getMessage(), 
                    "file" => $e->getFile(), 
                    "line" => $e->getLine()
                ]
            ]);

            return back();
        }
    }

    public function following(Request $request)
    {
        try{
            $decrypted_id = NULL;
            if($request->id != NULL){
                $decrypted_result = $this->common_library->decrypt_id($request->id);
                $decrypted_id = $decrypted_result['status'] != false ? $decrypted_result['id'] : throw new \Exception("Encrypted ID is corrupted.");
            }

            $user_id = $decrypted_id != NULL ? $decrypted_id : auth()->user()->id;

            $profile = Profile::where('user_id', '=', $user_id)->get();

            $user = User::find($user_id);

            $following = Follow::where('user_id', $user_id)->get(); 
            
            foreach($following as $key => $value){
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
                'following_list' => $following,
                'total_favorite' => $user->favorite()->get()->count(),
                'total_post' => Recipe::where('user_id', $user_id)->count(),
                'total_follower' => Follow::where('follow', $user_id)->count(),
                'total_following' => Follow::where('user_id', $user_id)->count(),
                'is_follow' => $this->follow->is_follow(auth()->user()->id, $decrypted_id),
                'userType' => 'member'
            ]);

        }catch(Throwable $e){
            CustomFile::index("FollowController", "error", [
                "message" => [
                    "code" => $e->getCode(),
                    "message" => $e->getMessage(), 
                    "file" => $e->getFile(), 
                    "line" => $e->getLine()
                ]
            ]);

            return back();
        }
    }

    public function follow(Request $request){
        try{
            $decrypted_id = NULL;

            if($request->id != NULL) {
                $decrypted_result = $this->common_library->decrypt_id($request->id);
                $decrypted_id = $decrypted_result['status'] != false ? $decrypted_result['id'] : throw new \Exception("Encrypted ID is corrupted.");
            }
            
            DB::beginTransaction();

                Follow::create([
                    'follow' => $decrypted_id,
                    'user_id' => auth()->user()->id
                ]);
        
            DB::commit();

            return redirect(route('profile.index', $request->id));

        }catch(Throwable $e){
            DB::rollBack();
            
            CustomFile::index("FollowController", "error", [
                "message" => [
                    "code" => $e->getCode(),
                    "message" => $e->getMessage(), 
                    "file" => $e->getFile(), 
                    "line" => $e->getLine()
                ]
            ]);

            return back();
        }
        
    }

    public function unfollow(Request $request){
        try{
            $decrypted_id = NULL;

            if($request->id != NULL) {
                $decrypted_result = $this->common_library->decrypt_id($request->id);
                $decrypted_id = $decrypted_result['status'] != false ? $decrypted_result['id'] : throw new \Exception("Encrypted ID is corrupted.");
            }
            DB::beginTransaction();

                $follow = Follow::where([
                    ['user_id', '=', auth()->user()->id],
                    ['follow', '=', $decrypted_id],
                ]);
                $follow->delete();

            DB::commit();
            
            return Redirect::back();

        }catch(Throwable $e){
            DB::rollBack();

            CustomFile::index("FollowController", "error", [
                "message" => [
                    "code" => $e->getCode(),
                    "message" => $e->getMessage(), 
                    "file" => $e->getFile(), 
                    "line" => $e->getLine()
                ]
            ]);

            return back();
        }
        
    }

    public function removeFollower(Request $request){
        try{
            $decrypted_id = NULL;

            if($request->id != NULL){
                $decrypted_result = $this->common_library->decrypt_id($request->id);
                $decrypted_id = $decrypted_result['status'] != false ? $decrypted_result['id'] : throw new \Exception("Encrypted ID is corrupted.");
            }
            
            DB::beginTransaction();

                $follow = Follow::where([
                    ['user_id', '=', $decrypted_id],
                    ['follow', '=', auth()->user()->id]
                ]);
        
                $follow->delete();

            DB::commit();

            return redirect(route('follower'));

        }catch(Throwable $e){
            DB::rollBack();

            CustomFile::index("FollowController", "error", [
                "message" => [
                    "code" => $e->getCode(),
                    "message" => $e->getMessage(), 
                    "file" => $e->getFile(), 
                    "line" => $e->getLine()
                ]
            ]);

            return back();
        }
    }
}
