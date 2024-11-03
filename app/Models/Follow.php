<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    protected $fillable = [
        'follow',
        'user_id'
    ];

    public function is_follow($user_id, $request_id){
        $items = Follow::select('id')
                    ->where('user_id', '=', $user_id)
                    ->where('follow', '=', $request_id)
                    ->count();

        $following = $items > 0 ? true : false;

        return $following;
    }
}
