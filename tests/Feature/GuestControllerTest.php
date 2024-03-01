<?php

namespace Tests\Feature;

use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GuestControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_can_view_guest(): void
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
    }

    public function test_can_show_recipe(): void
    {
        $recipe = Recipe::factory()->create();

        $response = $this->get('/guest/' . $recipe->id);
        
        $response->assertStatus(200);
    }
}
