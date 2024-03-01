<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FollowControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_can_get_follower(): void
    {
        $user_profile = new CreateUserProfile();
        $user = $user_profile->create_user_profile();

        $response = $this->actingAs($user)->get('/follower/' . $user->id);
        
        $response->assertSessionDoesntHaveErrors()
            ->assertStatus(200);
    }

    public function test_can_get_following(): void 
    {
        $user_profile = new CreateUserProfile();
        $user = $user_profile->create_user_profile();

        $response = $this->actingAs($user)->get('/following/' . $user->id);

        $response->assertSessionDoesntHaveErrors()
            ->assertStatus(200);
    }

    public function test_can_follow_user(): void 
    {
        $user_profile = new CreateUserProfile();
        $user = $user_profile->create_user_profile();
        $second_user = $user_profile->create_user_profile();

        $response = $this->actingAs($user)->get('/follow/' . $second_user->id);

        $response->assertSessionDoesntHaveErrors()
            ->assertRedirectToRoute('profile.index', $second_user->id);
    }

    public function test_can_unfollow_user(): void
    {
        $user_profile = new CreateUserProfile();
        $user = $user_profile->create_user_profile();
        $second_user = $user_profile->create_user_profile();

        $response = $this->actingAs($user)->get('/unfollow/' . $second_user->id);

        $response->assertSessionDoesntHaveErrors()
            ->assertRedirectToRoute('profile.index', $second_user->id);
    }

    public function test_can_remove_follower(): void
    {
        $user_profile = new CreateUserProfile();
        $user = $user_profile->create_user_profile();
        $second_user = $user_profile->create_user_profile();

        $response = $this->actingAs($user)->get('/remove/' . $second_user->id);

        $response->assertSessionDoesntHaveErrors()
            ->assertRedirectToRoute('profile.index', $user->id);
    }
}
