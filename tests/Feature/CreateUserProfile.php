<?php

namespace Tests\Feature;

use App\Models\Profile;
use App\Models\User;

class CreateUserProfile 
{
    public function create_user_profile() {
        $user = User::factory()->create();

        Profile::create([
            'user_id' => $user->id,
            'image' => 'assets/images/default_profile.svg',
            'thumbnail' => 'assets/images/default_profile.svg',
            'description' => 'Enter description here',
            'private' => 1
        ]);

        return $user;
    }
}
