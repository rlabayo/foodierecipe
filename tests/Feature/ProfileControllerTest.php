<?php

namespace Tests\Feature;

use App\Models\Profile;
use App\Models\Recipe;
use App\Models\User;
use App\Models\Favorite;
use App\Models\Follow;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $otherUser;

    public function setUp(): void
    {
        parent::setUp();

        // Create users for testing
        $this->user = User::factory()->create();
        $this->otherUser = User::factory()->create();

        // Create profile for users
        $this->user->profile()->create([
            'image' => 'assets/images/default_profile.svg',
            'thumbnail' => 'assets/images/default_profile.svg',
            'description' => 'Enter description here',
            'private' => 1
        ]);

        $this->otherUser->profile()->create([
            'image' => 'assets/images/default_profile.svg',
            'thumbnail' => 'assets/images/default_profile.svg',
            'description' => 'Enter other user description here',
            'private' => 1
        ]);

        // Create recipes for the user
        Recipe::factory()->create(['user_id' => $this->user->id, 'is_draft' => false]);
        Recipe::factory()->create(['user_id' => $this->user->id, 'is_draft' => true]);
        Recipe::factory()->create(['user_id' => $this->otherUser->id, 'is_draft' => false]);

        // Authenticate the user
        $this->actingAs($this->user);
    }

    /**
     * Test viewing own profile.
     */
    public function test_view_own_profile()
    {
        $response = $this->get(route('profile.index', Crypt::encrypt($this->user->id)));
var_dump($response);
        // $response->assertStatus(200)
        //          ->assertViewIs('web.profile.index');
                //  ->assertViewHas('user', $this->user)
                //  ->assertViewHas('profile');
    }

    // /**
    //  * Test viewing another user's profile.
    //  */
    // public function test_view_other_user_profile()
    // {
    //     $response = $this->get(route('profile.index', ['id' => encrypt($this->otherUser->id)]));

    //     $response->assertStatus(200)
    //              ->assertViewIs('web.profile.index')
    //              ->assertViewHas('user', $this->otherUser);
    // }

    // /**
    //  * Test profile editing form.
    //  */
    // public function test_edit_profile()
    // {
    //     $response = $this->get(route('profile.edit'));

    //     $response->assertStatus(200)
    //              ->assertViewIs('web.profile.edit')
    //              ->assertViewHas('user', $this->user);
    // }

    // /**
    //  * Test updating profile information.
    //  */
    // public function test_update_profile()
    // {
    //     $response = $this->put(route('profile.update'), [
    //         'name' => 'Updated User Name',
    //         'email' => 'updated@example.com',
    //         'description' => 'Updated description for the user',
    //         'password' => 'password123', // Assuming password is required for validation
    //         'password_confirmation' => 'password123'
    //     ]);

    //     $response->assertRedirect(route('profile.edit'))
    //              ->assertSessionHas('status', 'profile-updated');

    //     $this->user->refresh();

    //     $this->assertEquals('Updated User Name', $this->user->name);
    //     $this->assertEquals('updated@example.com', $this->user->email);
    //     $this->assertEquals('Updated description for the user', $this->user->profile->description);
    // }

    // /**
    //  * Test deleting user account.
    //  */
    // public function test_delete_user_account()
    // {
    //     $response = $this->delete(route('profile.destroy'), [
    //         'password' => 'password123' // The password must be correct to proceed with deletion
    //     ]);

    //     $response->assertRedirect('/')
    //              ->assertSessionHas('status', 'error-deleted');

    //     $this->assertNull(User::find($this->user->id));
    //     $this->assertNull(Profile::find($this->user->profile->id));
    //     $this->assertTrue(Auth::check() === false); // User is logged out
    // }

    // /**
    //  * Test viewing drafts for a user.
    //  */
    // public function test_view_user_drafts()
    // {
    //     $response = $this->get(route('profile.drafts', ['id' => encrypt($this->user->id)]));

    //     $response->assertStatus(200)
    //              ->assertViewIs('web.profile.index')
    //              ->assertViewHas('recipes')
    //              ->assertViewHas('user', $this->user);
    // }

    // /**
    //  * Test handling of non-existing user or encrypted ID issue.
    //  */
    // public function test_view_non_existent_user_profile()
    // {
    //     $response = $this->get(route('profile.index', ['id' => encrypt(9999)])); // non-existent user

    //     $response->assertRedirect(route('profile.error404'));
    // }

    // /**
    //  * Test handling of errors during profile update.
    //  */
    // public function test_update_profile_with_invalid_data()
    // {
    //     $response = $this->put(route('profile.update'), [
    //         'name' => '', // Invalid name
    //         'email' => 'updated@example.com',
    //         'description' => 'Updated description for the user',
    //         'password' => 'password123',
    //         'password_confirmation' => 'password123'
    //     ]);

    //     $response->assertStatus(302) // Should redirect back
    //              ->assertSessionHasErrors('name'); // Expecting validation errors for name
    // }

    // /**
    //  * Test that profile image directory is deleted when user is deleted.
    //  */
    // public function test_delete_profile_image_directory_on_user_deletion()
    // {
    //     Storage::fake('public');

    //     // Assuming user has a profile image stored
    //     $this->user->profile->update(['image' => 'user_image.jpg']);
        
    //     // Verify the directory exists
    //     Storage::disk('public')->put('uploads/profiles/user_' . $this->user->id, 'dummy-content');

    //     $this->delete(route('profile.destroy'), [
    //         'password' => 'password123'
    //     ]);

    //     // Assert that the directory was deleted
    //     Storage::disk('public')->assertMissing('uploads/profiles/user_' . $this->user->id);
    // }
}
?>