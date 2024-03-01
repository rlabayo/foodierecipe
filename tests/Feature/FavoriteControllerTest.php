<?php

namespace Tests\Feature;

use App\Models\Favorite;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FavoriteControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_can_view_favorite_page(): void
    {
        $user_profile = new CreateUserProfile();
        $user = $user_profile->create_user_profile();

        $response = $this->actingAs($user)->get('/favorite/' . $user->id);

        $response
            ->assertSessionHasNoErrors()
            ->assertStatus(200);
    }

    public function test_can_add_favorite_recipe(): void
    {
        $user_profile = new CreateUserProfile();
        $user = $user_profile->create_user_profile();

        $recipe = Recipe::factory()->create();

        $response = $this->actingAs($user)->get('/favorite/add/' . $recipe->id);

        $response
            ->assertSessionHasNoErrors()
            ->assertStatus(302); // 302 for redirect
    }

    public function test_can_remove_favorite_recipe(): void
    {
        $user_profile = new CreateUserProfile();
        $user = $user_profile->create_user_profile();

        $recipe = Recipe::factory()->create();

        $response = $this->actingAs($user)->get('/favorite/remove/' . $recipe->id);

        $response
            ->assertSessionHasNoErrors()
            ->assertStatus(302); // 302 for redirect
    }

}
