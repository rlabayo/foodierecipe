<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Recipe extends Model
{
    use HasFactory;

    protected $table = "recipes";

    // protected $casts = [
    //     'created_at' => 'datetime'
    // ];

    protected $fillable = [
        'id',
        'user_id',
        'title',
        'summary',
        'ingredients',
        'instruction',
        'video_url',
        'image',
        'thumbnail',
        'is_draft',
        'private',
        'created_at',
        'updated_at',
    ];

    public function comments(): HasMany {
        return $this->hasMany(Comment::class,'recipe_id');
    }

    /**
     * Retrieve a paginated list of public recipes along with their associated profile images.
     */
    public function get_public_recipes(){
        $items = Recipe::select('recipes.*', 'profiles.image AS profile_image')
                    ->leftJoin('profiles', 'recipes.user_id', '=', 'profiles.user_id')
                    ->where('recipes.private', '=', '0')
                    ->where('recipes.is_draft', '=', '0')
                    ->orderBy('created_at', 'desc')
                    ->paginate(6)
                    ->onEachSide(5);

        return $items;
    }

    /**
     * Get all recipes to display in member's wall 
     */

    public function get_all_recipes() {
        $items = Recipe::distinct()
                    ->select('recipes.*', 'profiles.image AS profile_image', 'users.name AS user_name')
                    ->leftJoin('profiles', 'recipes.user_id', '=', 'profiles.user_id')
                    // ->leftJoin('follows', 'recipes.user_id', '=', 'follows.follow') 
                    ->leftJoin('users', 'recipes.user_id', '=', 'users.id')
                    ->where('recipes.user_id', '!=', auth()->user()->id)
                    ->where('recipes.is_draft', '=', '0')
                    ->orderBy('recipes.created_at', 'desc')
                    // ->orderBy('follows.id', 'desc')
                    ->paginate(6)->onEachSide(5);


        
        foreach($items as $key => $item){
            $favorite = Favorite::where('recipe_id', '=', $item->id)
                    ->where('user_id', '=', auth()->user()->id)
                    ->get();

            $items[$key]->is_favorite = 0;
            $items[$key]->favorite_by = null;
            
            if($favorite->count() > 0){
                $items[$key]->favorite_id = $favorite[0]->id;
                $items[$key]->is_favorite = 1;
                $items[$key]->favorite_by = auth()->user()->id;
            }
        }
        
        return $items;
    }

    /**
     * Get the recipe details
     */
    public function get_recipe_details($id){
        
        $recipe = DB::table('recipes')
            ->select('recipes.*')
            ->selectRaw('favorites.id as favorite_id, (CASE WHEN favorites.id IS NULL then 0 else 1 END) AS is_favorite')
            ->rightJoin('favorites', 'recipes.id' , '=', 'favorites.recipe_id')
            ->where('recipes.id', '=', $id)
            ->get();
            dd($recipe);
            
        return $recipe;
    }

    public function get_all_following_recipes(){
        $items = Recipe::select('recipes.*', 'profiles.image AS profile_image')
                    ->leftJoin('profiles', 'recipes.user_id', '=', 'profiles.user_id')
                    ->leftJoin('follows', 'profiles.user_id', '=', 'follows.follow')
                    ->where('follows.user_id', '=', auth()->user()->id)
                    ->where('recipes.is_draft', '=', '0')
                    // ->where()
                    ->orderBy('created_at', 'desc')
                    ->paginate(6)
                    ->onEachSide(5);
        
        foreach($items as $key => $item){
            $favorite = Favorite::where('recipe_id', '=', $item->id)
                    ->where('user_id', '=', auth()->user()->id)
                    ->get();

            $items[$key]->is_favorite = 0;
            $items[$key]->favorite_by = null;
            
            if($favorite->count() > 0){
                $items[$key]->favorite_id = $favorite[0]->id;
                $items[$key]->is_favorite = 1;
                $items[$key]->favorite_by = auth()->user()->id;
            }
        }
        
        return $items;
    }


}
