<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_can_create_comment(): void
    {
        $user_profile = new CreateUserProfile();
        $user = $user_profile->create_user_profile();

        $recipe = Recipe::factory()->create();

        $response = $this->actingAs($user)->post('/comment/' . $user->id, [
            'user_id' => $user->id,
            'recipe_id' => $recipe->id,
            'comment' => 'test comment'
        ]);

        $response->assertSessionHasNoErrors()
                ->assertRedirect(session()->previousUrl());
    }

    public function test_can_update_comment(): void 
    {
        $user_profile = new CreateUserProfile();
        $user = $user_profile->create_user_profile();

        $recipe = Recipe::factory()->create();
        $comment = Comment::create([
            'user_id' => $user->id,
            'recipe_id' => $recipe->id,
            'comment' => 'test comment'
        ]);

        $response = $this->actingAs($user)->patch('/comment/', [
            'id' => $comment->id,
            'comment' => 'update comment'
        ]);

        $response->assertSessionHasNoErrors()
                ->assertRedirect(session()->previousUrl());
    }

    public function test_can_delete_comment(): void 
    {
        $user_profile = new CreateUserProfile();
        $user = $user_profile->create_user_profile();

        $recipe = Recipe::factory()->create();

        $comment = Comment::create([
            'user_id' => $user->id,
            'recipe_id' => $recipe->id,
            'comment' => 'test comment'
        ]);

        $response = $this->actingAs($user)->delete('/comment/' . $comment->id);

        $response->assertSessionHasNoErrors()
                ->assertRedirect(session()->previousUrl());

    }
}
