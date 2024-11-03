<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\SearchController;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Root route
Route::get('/', function() {
    // Check authentication
    if (Auth::check()) {
        // Redirect if authenticated
        return redirect(route('member'));
    }
    // Handle guest users
    return App::call('App\Http\Controllers\GuestController@index');
})->name('home');

Route::get('/g/recipe/{id}', [GuestController::class, 'show'])->name('guest.show');

// Search nav bar
Route::match(['get', 'post'], '/search', [SearchController::class, 'search'])->name('search');
// Show more in recipe searh
Route::get('/search_recipe/{param}', [SearchController::class, 'get_recipes'])->name('search.recipes');
// Show more in profile search
Route::get('/search_profile]/{param}', [SearchController::class, 'get_profiles'])->name('search.profiles');

// Updated auth route
Route::middleware('auth')->group(function () {
    // Home
    Route::get('/m', [HomeController::class, 'index'])->name('member');
    
    // Recipe
    Route::get('/m/recipe/create', [RecipeController::class, 'create'])->name('recipe.create');
    Route::get('/m/recipe/drafts', [ProfileController::class, 'drafts'])->name('drafts');
    Route::get('/m/recipe/{id}', [RecipeController::class, 'show'])->name('recipe.show');
    Route::get('/m/recipe/{id}/edit', [RecipeController::class, 'edit'])->name('recipe.edit');
    Route::post('/m/recipe', [RecipeController::class, 'store'])->name('recipe.store');
    Route::patch('/m/recipe/{id}', [RecipeController::class, 'update'])->name('recipe.update');
    Route::delete('/m/recipe/{id}', [RecipeController::class, 'destroy'])->name('recipe.delete');

    // Profile
    Route::get('/profile/{id?}', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/user/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/profile/error/404', function(){
        $message = "The profile requested could not be found on this server!";
        
        return view('errors.profile_404', compact('message'));
    })->name('profile.error404');

    // Avatar 
    Route::patch('/avatar', [AvatarController::class, 'update'])->name('avatar.update');

    // Favorite
    Route::get('/favorite/{id}', [FavoriteController::class, 'index'])->name('favorite.index');
    Route::get('/favorite/add/{id}', [FavoriteController::class, 'add'])->name('favorite.add');
    Route::get('/favorite/remove/{id}', [FavoriteController::class, 'remove'])->name('favorite.remove');

    // Comments
    Route::post('/comment/{id}', [CommentController::class, 'store'])->name('comment.add');
    Route::patch('/comment', [CommentController::class, 'update'])->name('comment.update');
    Route::delete('/comment/{id}', [CommentController::class, 'destroy'])->name('comment.destroy');

    // Follow
    Route::get('/follower/{id}', [FollowController::class, 'follower'])->name('follower');
    Route::get('/following/{id}', [FollowController::class, 'following'])->name('following');
    Route::get('/follow/{id}', [FollowController::class, 'follow'])->name('follow');
    Route::get('/unfollow/{id}', [FollowController::class, 'unfollow'])->name('unfollow');
    Route::get('/follower/remove/{id}', [FollowController::class, 'removeFollower'])->name('removeFollower');

});

// Updated auth route and isadmin
Route::middleware(['auth', 'is.admin'])->group(function () {
    
});


Route::get('/recipe/error/404', function(){
    $message = "The recipe requested could not be found on this server!";
        
    return view('errors.recipe_404', compact('message'));
})->name('error404');

Route::middleware(['auth', 'is.admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/account_verify/{id}', [AdminController::class, 'verify_account'])->name('admin.verify_account');
});


// Route::get('/admin', function(){
//     return view('web.admin.index');
// })->name('admin.index');

// Route::post('/admin', function(Request $request){
//     dd($request);
// })->name('admin');

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

Route::get('/cache_config', function () {
    Artisan::call('config:cache');
});

// Route::get('/list', function() {
//     return view('web.form');
// });

require __DIR__.'/auth.php';
