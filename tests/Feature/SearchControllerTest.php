<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_can_search(): void
    {
        $user_profile = new CreateUserProfile();
        $user = $user_profile->create_user_profile();

        $response = $this->get('/search', ['search' => '']);
        
        $response->assertSessionDoesntHaveErrors()
            ->assertFound();
    }
}
