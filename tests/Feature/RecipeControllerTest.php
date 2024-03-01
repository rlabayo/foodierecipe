<?php

namespace Tests\Feature;

use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class RecipeControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_can_view_recipe_wall(): void
    {
        $user_profile = new CreateUserProfile();
        $user = $user_profile->create_user_profile();

        $response = $this->actingAs($user)->get('/recipe');

        $response->assertSessionDoesntHaveErrors()
            ->assertStatus(200);
    }

    public function test_can_view_create_recipe_page(): void
    {
        $user_profile = new CreateUserProfile();
        $user = $user_profile->create_user_profile();

        $response = $this->actingAs($user)->get('/recipe/create');

        $response->assertSessionDoesntHaveErrors()
            ->assertStatus(200);
    }

    public function test_can_store_recipe(): void
    {
        $user_profile = new CreateUserProfile();
        $user = $user_profile->create_user_profile();

        $response = $this->actingAs($user)->post('/recipe', [
            'user_id' => $user->id,
            'title' => 'Homemade Sushi',
            'summary' => 'Sushi rolls can be filled with any ingredients you choose. Try smoked salmon instead of imitation crabmeat. Serve with teriyaki sauce and wasabi.',
            'ingredients' => '[{"item":"1 ⅓ cups water"},{"item":"⅔ cup uncooked short-grain white rice"},{"item":"3 tablespoons rice vinegar"},{"item":"3 tablespoons white sugar"},{"item":"1 ½ teaspoons salt"},{"item":"4 sheets nori seaweed sheets"},{"item":"½ pound imitation crabmeat, flaked"},{"item":"1 avocado - peeled, pitted, and sliced"},{"item":"½ cucumber, peeled, cut into small strips"},{"item":"2 tablespoons pickled ginger"}]',
            'instruction' => '[{"instruction_item":"Gather all ingredients. Preheat the oven to 300 degrees F (150 degrees C).","attached_photo":"uploads\/recipes\/user_1\/instruction\/240207_1707309499_E0Ksaxew9M.webp"},{"instruction_item":"Bring water to a boil in a medium pot; stir in rice. Reduce heat to medium-low, cover, and simmer until rice is tender and water has been absorbed, 20 to 25 minutes.","attached_photo":""},{"instruction_item":"Mix rice vinegar, sugar, and salt in a small bowl. Gently stir into cooked rice in the pot and set aside.","attached_photo":"uploads\/recipes\/user_1\/instruction\/240207_1707309499_X6DUi4Qqig.webp"},{"instruction_item":"Lay nori sheets on a baking sheet.\n\n","attached_photo":"uploads\/recipes\/user_1\/instruction\/240207_1707309499_9xqGHPkEyJ.webp"},{"instruction_item":"Heat nori in the preheated oven until warm, 1 to 2 minutes.","attached_photo":""},{"instruction_item":"Center 1 nori sheet on a bamboo sushi mat. Use wet hands to spread a thin layer of rice on top. Arrange 1\/4 of the crabmeat, avocado, cucumber, and pickled ginger over rice in a line down the center.","attached_photo":"uploads\/recipes\/user_1\/instruction\/240207_1707309499_fNfoKO7LUT.webp"},{"instruction_item":"Lift one end of the mat and roll it tightly over filling to make a complete roll. Repeat with remaining ingredients.","attached_photo":"uploads\/recipes\/user_1\/instruction\/240207_1707309499_Wqx9GZxRrh.webp"},{"instruction_item":"Use a wet, sharp knife to cut each roll into 4 to 6 slices.","attached_photo":"uploads\/recipes\/user_1\/instruction\/240207_1707309499_E4Abpp3ybd.webp"}]',
            'video_url' => '',
            'private' => rand(0,1),
            'image' => $file = UploadedFile::fake()->image('post.jpg'),
            'thumbnail' => $file = UploadedFile::fake()->image('post.jpg'),
            'unit' => 'cups'
        ]);

        $response->assertSessionHasNoErrors()
                ->assertRedirect(session()->previousUrl());
    }

    public function test_can_show_recipe(): void
    {
        $user_profile = new CreateUserProfile();
        $user = $user_profile->create_user_profile();

        $recipe = Recipe::factory()->create();

        $response = $this->actingAs($user)->get('/recipe/' . $recipe->id);

        $response->assertSessionDoesntHaveErrors()
            ->assertOk(200);

    }

    public function test_can_view_edit_page(): void
    {
        $user_profile = new CreateUserProfile();
        $user = $user_profile->create_user_profile();

        $recipe = Recipe::factory()->create();

        $response = $this->actingAs($user)->get('/recipe/'. $recipe->id .'/edit');

        $response->assertSessionDoesntHaveErrors()
            ->assertOk(200);
    }

    public function test_can_update_recipe(): void
    {
        $user_profile = new CreateUserProfile();
        $user = $user_profile->create_user_profile();

        $recipe = Recipe::factory()->create();

        $response = $this->actingAs($user)->patch('/recipe/' . $recipe->id, [
            'title' => 'Homemade Sushi Update',
            'summary' => 'Sushi rolls can be filled with any ingredients you choose. Try smoked salmon instead of imitation crabmeat. Serve with teriyaki sauce and wasabi.',
            'ingredients' => '[{"item":"1 ⅓ cups water"},{"item":"⅔ cup uncooked short-grain white rice"},{"item":"3 tablespoons rice vinegar"},{"item":"3 tablespoons white sugar"},{"item":"1 ½ teaspoons salt"},{"item":"4 sheets nori seaweed sheets"},{"item":"½ pound imitation crabmeat, flaked"},{"item":"1 avocado - peeled, pitted, and sliced"},{"item":"½ cucumber, peeled, cut into small strips"},{"item":"2 tablespoons pickled ginger"}]',
            'instruction' => '[{"instruction_item":"Gather all ingredients. Preheat the oven to 300 degrees F (150 degrees C).","attached_photo":"uploads\/recipes\/user_1\/instruction\/240207_1707309499_E0Ksaxew9M.webp"},{"instruction_item":"Bring water to a boil in a medium pot; stir in rice. Reduce heat to medium-low, cover, and simmer until rice is tender and water has been absorbed, 20 to 25 minutes.","attached_photo":""},{"instruction_item":"Mix rice vinegar, sugar, and salt in a small bowl. Gently stir into cooked rice in the pot and set aside.","attached_photo":"uploads\/recipes\/user_1\/instruction\/240207_1707309499_X6DUi4Qqig.webp"},{"instruction_item":"Lay nori sheets on a baking sheet.\n\n","attached_photo":"uploads\/recipes\/user_1\/instruction\/240207_1707309499_9xqGHPkEyJ.webp"},{"instruction_item":"Heat nori in the preheated oven until warm, 1 to 2 minutes.","attached_photo":""},{"instruction_item":"Center 1 nori sheet on a bamboo sushi mat. Use wet hands to spread a thin layer of rice on top. Arrange 1\/4 of the crabmeat, avocado, cucumber, and pickled ginger over rice in a line down the center.","attached_photo":"uploads\/recipes\/user_1\/instruction\/240207_1707309499_fNfoKO7LUT.webp"},{"instruction_item":"Lift one end of the mat and roll it tightly over filling to make a complete roll. Repeat with remaining ingredients.","attached_photo":"uploads\/recipes\/user_1\/instruction\/240207_1707309499_Wqx9GZxRrh.webp"},{"instruction_item":"Use a wet, sharp knife to cut each roll into 4 to 6 slices.","attached_photo":"uploads\/recipes\/user_1\/instruction\/240207_1707309499_E4Abpp3ybd.webp"}]',
            'video_url' => '',
            'private' => rand(0,1),
            'image' => $file = UploadedFile::fake()->image('post.jpg'),
            'thumbnail' => $file = UploadedFile::fake()->image('post.jpg'),
            'unit' => 'cups'
        ]);

        $response->assertSessionDoesntHaveErrors()
            ->assertRedirect(session()->previousUrl());
    }

    public function test_can_delete_recipe(): void
    {
        $user_profile = new CreateUserProfile();
        $user = $user_profile->create_user_profile();

        $recipe = Recipe::factory()->create();

        $response = $this->actingAs($user)->delete('/recipe/' . $recipe->id);

        $response->assertSessionDoesntHaveErrors()
            ->assertRedirect(session()->previousUrl());
    }

}
