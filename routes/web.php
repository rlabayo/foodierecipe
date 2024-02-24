<?php

use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\SearchController;
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

Route::get('/',  function(){
    if(Auth::check()){
        return redirect(route('recipe.index'));
    }
    return App::call('App\Http\Controllers\GuestController@index');
});
Route::get('/guest/{id}', [GuestController::class, 'show'])->name('guest.show');

Route::middleware('auth')->group(function () {
    Route::get('/recipe', [RecipeController::class, 'index'])->name('recipe.index');
    Route::get('/recipe/create', [RecipeController::class, 'create'])->name('recipe.create');
    Route::get('/recipe/{id}', [RecipeController::class, 'show'])->name('recipe.show');
    Route::get('/recipe/{id}/edit', [RecipeController::class, 'edit'])->name('recipe.edit');
    Route::post('/recipe', [RecipeController::class, 'store'])->name('recipe.store');
    Route::patch('/recipe/{id}', [RecipeController::class, 'update'])->name('recipe.update');
    Route::delete('/recipe/{id}', [RecipeController::class, 'destroy'])->name('recipe.delete');

    Route::get('/favorite/{id}', [FavoriteController::class, 'index'])->name('favorite.index');
    Route::get('/favorite/add/{id}', [FavoriteController::class, 'add'])->name('favorite.add');
    Route::get('/favorite/remove/{id}', [FavoriteController::class, 'remove'])->name('favorite.remove');

    Route::get('/profile/{id?}', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/user/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::patch('/avatar', [AvatarController::class, 'update'])->name('avatar.update');

    Route::get('/follower/{id}', [FollowController::class, 'follower'])->name('follower');
    Route::get('/following/{id}', [FollowController::class, 'following'])->name('following');
    Route::get('/follow/{id}', [FollowController::class, 'follow'])->name('follow');
    Route::get('/unfollow/{id}', [FollowController::class, 'unfollow'])->name('unfollow');
    Route::get('/remove/{id}', [FollowController::class, 'removeFollower'])->name('removeFollower');

    Route::post('/comment/{id}', [CommentController::class, 'store'])->name('comment.add');
    Route::patch('/comment', [CommentController::class, 'update'])->name('comment.update');
    Route::delete('/comment/{id}', [CommentController::class, 'destroy'])->name('comment.destroy');

    Route::get('/profile/error/404', function(){
        $message = "The profile requested could not be found on this server!";
        
        return view('errors.profile_404', compact('message'));
    })->name('profile.error404');

    Route::get('/search', [SearchController::class, 'search'])->name('search');
});


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
