<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AvatarControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_avatar_can_update(): void
    {
        $user_profile = new CreateUserProfile();
        $user = $user_profile->create_user_profile();

        $response = $this->actingAs($user)->patch('/avatar', [
            'avatar' => $file = UploadedFile::fake()->image('post.jpg')
        ]);

        $response
        ->assertSessionHasNoErrors()
        ->assertRedirectToRoute('profile.edit');
    }


    
}
