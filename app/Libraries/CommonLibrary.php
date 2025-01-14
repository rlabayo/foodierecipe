<?php

namespace App\Libraries;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Throwable;

class CommonLibrary {

    public function get_recommendation($id, $exploded_title)
    {
        $recommendation_list = DB::table('recipes')->select('id', 'title')
            ->orWhere(function (Builder $query) use($exploded_title) {
                foreach($exploded_title as $key => $element) {
                    if($key == 0) {
                        $query->where('title', 'like', '%'.$element.'%')
                            ->orwhere('ingredients', 'like', '%'.$element.'%');
                    }
                        $query->orWhere('title', 'like', '%'.$element.'%')
                            ->orwhere('ingredients', 'like', '%'.$element.'%');
                }
            })
            ->where('id', '<>', $id)
            ->where(function (Builder $query) {
                if(!Auth::check()){
                    $query->where('private', '<>', '1');
                }
            })
            ->limit(5)->get();

        return $recommendation_list;
    }

    public function decrypt_id($encrypted_id){
        try{
            // Decrypted the given ID
            $decrypted_id = Crypt::decrypt($encrypted_id);
            
            // If decryption is successful, return the decrypted ID
            
            $result['id'] = $decrypted_id;
            $result['status'] = true;
            
            return $result;
        }catch(Throwable $e){
            $result['status'] = false;

            // Handle the case where decryption fails
            return $result;
        }
    }

}

?>