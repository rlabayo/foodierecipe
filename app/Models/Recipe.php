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
        'unit',
        'private',
        'created_at',
        'updated_at',
    ];

    public function comments(): HasMany {
        return $this->hasMany(Comment::class,'recipe_id');
    }

    // Guest
    public function get_public_recipes(){
        $items = Recipe::select('recipes.*', 'profiles.image AS profile_image')
                    ->leftJoin('profiles', 'recipes.user_id', '=', 'profiles.user_id')
                    ->where('recipes.private', '=', '0')
                    ->orderBy('created_at', 'desc')->paginate(6)->onEachSide(5);

        return $items;
    }

    public function get_all_recipes() {
        $items = Recipe::distinct()
                    ->select('recipes.*', 'profiles.image AS profile_image')
                    ->leftJoin('profiles', 'recipes.user_id', '=', 'profiles.user_id')
                    ->where('recipes.user_id', '!=', auth()->user()->id)
                    ->orderBy('recipes.id', 'desc')
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

}
