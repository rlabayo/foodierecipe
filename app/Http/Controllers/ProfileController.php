<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Libraries\CommonLibrary;
use App\Logging\CustomFile;
use App\Models\Favorite;
use App\Models\Follow;
use App\Models\Profile;
use App\Models\Recipe;
use App\Models\User;
use Error;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Throwable;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;

class ProfileController extends Controller
{
    public $follow;
    public $favorite;
    public $common_library;

    public function __construct()
    {
        $this->follow = new Follow();
        $this->favorite = new Favorite();
        $this->common_library = new CommonLibrary();
    }

    public function index(Request $request)//: View 
    { 
        try{
            // Set custom url path for show recipe back button
            session(['customPrevURL' => parse_url(url()->current(), PHP_URL_PATH)]);

            $decrypted_id = NULL;

            if($request->id != NULL) {
                // Decrypt the given ID
                $decrypted_result = $this->common_library->decrypt_id($request->id);
                $decrypted_id = $decrypted_result['status'] != false ? $decrypted_result['id'] : throw new \Exception("Encrypted ID is corrupted.");
            }

            // Set the value of user id to decrypted ID or auth user ID
            $user_id = $decrypted_id != NULL ? $decrypted_id : auth()->user()->id;
            // Get the profile details that are associated with the given user ID
            $profile = Profile::where('user_id', '=', $user_id)->get();
            // Get the list of recipes that are not in draft status and are associated with the given user ID.
            $recipes = Recipe::where(['user_id' => $user_id, 'is_draft' => '0'])
                                ->join('users', 'users.id', '=', 'recipes.user_id') // Join the profiles table
                                ->select('recipes.*', 'users.name as user_name')
                                ->latest()->get();
            // Get the user details that are associated with the given user ID
            $user = User::find($user_id);
            
            if($user == NULL) {
                throw new \Exception("Error getting user details.");
            }
            
            if($decrypted_id != auth()->user()->id){
                // check if the recipes are user's favorites
                foreach($recipes as $key => $item){
                    $favorite_list = $this->favorite->is_favorite(auth()->user()->id, $item['id']);
                    
                    // if recipe is a favorite of the current user
                    if($favorite_list != FALSE){
                        $recipes[$key]->favorite_id = $favorite_list[0]->favorite_id;
                        $recipes[$key]->is_favorite = 1;
                        $recipes[$key]->favorite_by = $favorite_list[0]->favorite_by;
                    }
                }
            }

            return view('web.profile.index', [
                'user' => $user,
                'profile' => $profile[0],
                'recipes' => $recipes,
                'total_favorite' => $user->favorite()->get()->count(),
                'total_post' => Recipe::where('user_id', $user_id)->count(),
                'total_follower' => Follow::where('follow', $user_id)->count(),
                'total_following' => Follow::where('user_id', $user_id)->count(),
                'is_follow' => $this->follow->is_follow(auth()->user()->id, $decrypted_id),
                'userType' => 'member'
            ]);
        }catch(Throwable $e){
            // Create or update the log file for error
            CustomFile::index('ProfileController', 'error', [
                'message' => ['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()],
            ]);

            return redirect(route('profile.error404'));
        }
    }

    public function show(Request $request)
    {
        try{
            // Decrypt the given ID
            $decrypted_result = $this->common_library->decrypt_id($request->id);
            $decrypted_id = $decrypted_result['status'] != false ? $decrypted_result['id'] : throw new \Exception("Encrypted ID is corrupted.");

            // Get the profile details that are associated with the given user ID
            $profile = Profile::where('user_id', '=', $decrypted_id)->get();
            // Get the list of recipes that are associated with the given user ID.
            $recipes = Recipe::where('user_id', $decrypted_id)->latest()->paginate(6);

            // Get the user details that are associated with the given user ID
            $user = User::find($decrypted_id);
            // Get the favorite list of the user
            $favorite_list = $user->favorite()->get();

            return view('web.profile.index', [
                'user' => $user,
                'profile' => $profile[0],
                'recipes' => $recipes,
                'favorites' => $favorite_list,
                'total_favorite' => $user->favorite()->get()->count(),
                'total_post' => Recipe::where('user_id', $decrypted_id)->count()
            ]);
        }catch(Throwable $e){
            // Create or update the log file for error
            CustomFile::index('ProfileController', 'error', [
                'message' => ['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()],
            ]);

            return redirect(route('profile.error404'));
        }
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('web.profile.edit', [
            'user' => $request->user(),
            'profile' => $request->user()->profile
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        try{
            DB::beginTransaction();

                $request->user()->fill($request->validated());

                if ($request->user()->isDirty('email')) {
                    $request->user()->email_verified_at = null;
                }

                $request->user()->profile->update(
                    ['description' => $request->description]
                );

                $request->user()->save();

            DB::commit();

            return Redirect::route('profile.edit')->with('status', 'profile-updated');

        }catch(Throwable $e){
            DB::rollBack();

            // Call in controller
            CustomFile::index('ProfileController', 'error', [
                'message' => ['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()],
            ]);
            
            return back()->withInput()->with('status', 'error-updated');
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        try{
            DB::beginTransaction();

                $request->validateWithBag('userDeletion', [
                    'password' => ['required', 'current_password'],
                ]);
                
                $user = $request->user();
                
                // Get profile info, 
                $profile = $user->profile;

                // Delete profile folder in public storage
                $path_recipes = "uploads/recipes/user_". $user->id;
                if(Storage::disk('public')->exists($path_recipes)){
                    Storage::disk('public')->deleteDirectory($path_recipes);
                }
                
                $path_profile = "uploads/profiles/user_". $user->id;
                if(Storage::disk('public')->exists($path_profile)){
                    Storage::disk('public')->deleteDirectory($path_profile);
                }
                
                // Delete profile 
                $profile->delete();

                $recipes = Recipe::where('user_id', $user->id);

                // Delete the favorite entries of the recipe
                foreach($recipes->get() as $recipe){
                    Favorite::where('recipe_id', $recipe['id'])->delete();
                }

                // Remove Followers
                Follow::where('follow', $user->id)->delete();
                // Remove Following
                Follow::where('user_id', $user->id)->delete();

                // Delete all recipes of the user
                $recipes->delete();

                Auth::logout();

                $user->delete();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

            DB::commit();

            return Redirect::to('/');

        }catch(Throwable $e){
            DB::rollBack();

            // Call in controller
            CustomFile::index('ProfileController', 'error', [
                'message' => ['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()],
            ]);

            return back()->with('status', 'error-deleted');
        }
    }

    public function drafts(Request $request){

        // Set custom url path for show recipe back button
        session(['customPrevURL' => parse_url(url()->current(), PHP_URL_PATH)]);

        $user_id = $request->id != NULL ? $request->id : auth()->user()->id;
        $profile = Profile::where('user_id', '=', $user_id)->get();
        $recipes = Recipe::where(['user_id' => $user_id, 'is_draft' => '1'])->latest()->get();
        $user = User::find($user_id);
        
        if($user == null) {
            return redirect(route('profile.error404'));
        }
        
        if($request->id != auth()->user()->id){
            $favorite_model = new Favorite();

            // check if the recipes are user's favorites
            foreach($recipes as $key => $item){
                $favorite_result = $favorite_model->is_favorite(auth()->user()->id, $item['id']);
                
                // if recipe is a favorite of the current user
                if($favorite_result != false){
                    $recipes[$key]->favorite_id = $favorite_result[0]->favorite_id;
                    $recipes[$key]->is_favorite = 1;
                    $recipes[$key]->favorite_by = $favorite_result[0]->favorite_by;
                }
            }
        }

        return view('web.profile.index', [
            'user' => $user,
            'profile' => $profile[0],
            'recipes' => $recipes,
            'total_favorite' => $user->favorite()->get()->count(),
            'total_post' => Recipe::where('user_id', $user_id)->count(),
            'total_follower' => Follow::where('follow', $user_id)->count(),
            'total_following' => Follow::where('user_id', $user_id)->count(),
            'is_follow' => $this->follow->is_follow(auth()->user()->id, $request->id),
            'userType' => 'member'
        ]);
    }
}
