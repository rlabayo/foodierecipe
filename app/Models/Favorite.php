<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'recipe_id'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function is_favorite($user_id, $recipe_id) {
        $query = DB::table('recipes')
                ->select('favorites.id AS favorite_id', 'favorites.user_id AS favorite_by', 'recipes.id AS recipe_id')
                ->leftJoin('favorites', 'recipes.id', '=', 'favorites.recipe_id')
                ->where('favorites.user_id', '=', $user_id)
                ->where('favorites.recipe_id', '=', $recipe_id);
            
        if($query->count() == 0){
            return false;
        }
        return $query->get();
    }
}
