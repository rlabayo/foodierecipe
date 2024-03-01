<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $user_profile = new CreateUserProfile();
        $user = $user_profile->create_user_profile();

        $response = $this->actingAs($user)
            ->get('/profile');

        $response->assertOk();
    }

    public function test_profile_can_be_viewed(): void
    {
        $user_profile = new CreateUserProfile();
        $user = $user_profile->create_user_profile();

        $response = $this->actingAs($user)
                ->get('/profile/' . $user->id);

        $response->assertOk();
    }

    public function test_profile_can_be_edited(): void
    {
        $user_profile = new CreateUserProfile();
        $user = $user_profile->create_user_profile();

        $response = $this->actingAs($user)
                ->get('/profile/user/edit');

        $response->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user_profile = new CreateUserProfile();
        $user = $user_profile->create_user_profile();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'description' => 'Good food. Happy Tummy.'
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirectToRoute('profile.edit');

        $user->profile->refresh();

        $this->assertSame('Test User', $user->name);
        $this->assertSame('test@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    // public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    // {
    //     $user = User::factory()->create();

    //     $response = $this
    //         ->actingAs($user)
    //         ->patch('/profile', [
    //             'name' => 'Test User',
    //             'email' => $user->email,
    //             'description' => 'Good food. Happy Tummy.'
    //         ]);

    //     $response
    //         ->assertSessionHasNoErrors()
    //         ->assertRedirect('/profile');

    //     $this->assertNotNull($user->refresh()->email_verified_at);
    // }

    public function test_user_can_delete_their_account(): void
    {
        $user_profile = new CreateUserProfile();
        $user = $user_profile->create_user_profile();

        $response = $this
            ->actingAs($user)
            ->delete('/profile', [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
        $this->assertNull($user->fresh());
    }

    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $user_profile = new CreateUserProfile();
        $user = $user_profile->create_user_profile();

        $response = $this
            ->actingAs($user)
            ->from('/profile/user/edit')
            ->delete('/profile', [
                'password' => 'wrong-password',
            ]);

        $response
            // ->assertSessionHasErrorsIn('userDeletion', 'password')
            ->assertRedirectToRoute('profile.edit');

        $this->assertNotNull($user->fresh());
    }

}
