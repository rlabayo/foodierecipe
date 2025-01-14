<?php

namespace App\Http\Controllers;

use App\Libraries\CommonLibrary;
use App\Logging\CustomFile;
use App\Models\Favorite;
use App\Models\Follow;
use App\Models\Profile;
use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class FavoriteController extends Controller
{
    public $follow;
    public $common_library;

    public function __construct()
    {
        $this->follow = new Follow();
        $this->common_library = new CommonLibrary();
    }

    public function index(Request $request)//: View 
    {
        try{
            // Set custom url path for show recipe back button
            session(['customPrevURL' => parse_url(url()->current(), PHP_URL_PATH)]);

            $decrypted_id = NULL;

            if($request->id != NULL) {
                $decrypted_result = $this->common_library->decrypt_id($request->id);
                $decrypted_id = $decrypted_result['status'] != false ? $decrypted_result['id'] : throw new \Exception("Encrypted ID is corrupted.");
            }

            $user_id = $decrypted_id != NULL ? $decrypted_id : auth()->user()->id;
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
                'is_follow' => $this->follow->is_follow(auth()->user()->id, $decrypted_id),
                'userType' => 'member'
            ]);

        }catch(Throwable $e){
            CustomFile::index("FavoriteController", "error", ["message" => ["message" => $e->getMessage(), "file" => $e->getFile(), "line" => $e->getLine()]]);

            return redirect(route('favorite.error404'));
        }
    }

    public function add(Request $request){
        try{
            $decrypted_result = $this->common_library->decrypt_id($request->id);
            $decrypted_id = $decrypted_result['status'] != false ? $decrypted_result['id'] : throw new \Exception("Encrypted ID is corrupted.");

            DB::beginTransaction();
                $created_data = Favorite::create([
                    'user_id' => auth()->user()->id,
                    'recipe_id' => $decrypted_id
                ]);
            DB::commit();
            
            return back();
        }catch(Throwable $e){
            DB::rollBack();

            CustomFile::index('FavoriteController', 'error', [
                'message' => ['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()]
            ]);

            return back();
        }
    }

    public function remove(Request $request) {
        try{
            $decrypted_result = $this->common_library->decrypt_id($request->id);
            $decrypted_id = $decrypted_result['status'] != false ? $decrypted_result['id'] : throw new \Exception("Encrypted ID is corrupted.");

            DB::beginTransaction();
                $deleted_data = Favorite::where('id', $decrypted_id)->delete();
            DB::commit();

            return back();
            
        }catch(Throwable $e){
            DB::rollBack();

            CustomFile::index("FavoriteController", "error", [
                "message" => ["message" => $e->getMessage(), "file" => $e->getFile(), "line" => $e->getLine()]
            ]);

            return back();
        }
    }

    public function store(Request $request){
        try{
            Favorite::create([
                'user_id' => auth()->user()->id,
                'recipe_id' => $request->id
            ]);
    
            return redirect("recipe/$request->id");
        }catch(Throwable $e){
            CustomFile::index("FavoriteController", "error", [
                "message" => ["message" => $e->getMessage(), "file" => $e->getFile(), "line" => $e->getLine()]
            ]);

            return back();
        }
        
    }

    // public function check(Request $request) {
    //     echo "<pre>";
    //     $favorite = new Favorite;
    //     $is_favorite = $favorite->is_favorite(auth()->user()->id, $request->id);
    //     // $check = Favorite::where('user_id', auth()->user()->id)->where('recipe_id', $request->id)->first();

    //     if($is_favorite === false) {
    //         // Favorite::create([
    //         //     'user_id' => auth()->user()->id,
    //         //     'recipe_id' => $request->id
    //         // ]);
    //     }else {
            
    //     }
    //     // var_dump($check);
    // }

    // public function show(){
        
    // }



}
