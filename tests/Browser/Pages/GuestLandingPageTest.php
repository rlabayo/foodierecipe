<?php

namespace Tests\Browser;

use App\Models\Recipe;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class GuestLandingPageTest extends DuskTestCase
{
    /**
     * Guest landing page test.
     */
    public function testGoToGuestLandingPage(): void
    {
        Recipe::factory()->create();

        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee("Shared Public Recipe")
                ->screenshot('guest/guest-landing-page');
        });
    }

    /**
     * Got to show recipe page by clicking recipe title test
     */
    public function testGoToShowRecipePageByClickingTitle(): void
    {
        $recipe = Recipe::latest()->get()[0];
        $this->browse(function (Browser $browser) use ($recipe) {
            $browser->visit('/');
            $browser->screenshot('guest/recipe-list-before-go-to-show-recipe');
            $browser->clickLink($recipe->title);
            $browser->assertSee($recipe->title);
            $browser->screenshot('guest/show-recipe-page-after-clicking-title');
        });
    }

    /**
     * Go to show recipe page by clicking view button test
     */
    public function testGoToShowRecipePageByClickingViewButton(): void
    {
        $recipe = Recipe::latest()->get()[0];

        $this->browse(function (Browser $browser) use ($recipe) {
            $browser->visit('/')
                ->click('a[href="'. env('APP_URL') .'guest/'. $recipe->id .'"')
                ->assertSee($recipe->title)
                ->screenshot('guest/show-recipe-page-after-clicking-view-button');
        });
    }

    /**
     * Go to user profile test
     */
    public function testGoToUserProfile(): void
    {
        $recipe = Recipe::latest()->get()[0];

        $this->browse(function (Browser $browser) use ($recipe) {
            $browser->visit('/')
                ->click('a[href="'. env('APP_URL') .'profile/'. $recipe->user_id .'"]')
                ->assertSee('Log In')
                ->screenshot('guest/go-to-profile');
        });
    }

    /**
     * Go to log in page test
     */
    public function testGoToLogInPage(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Shared Public Recipe')
                ->click('a[href="'. env('APP_URL') .'login"]')
                ->assertSee('Log In')
                ->screenshot('guest/log-in-page');
        });
    }

    /**
     * Go to register page test
     */
    public function testGoToRegisterPage(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Shared Public Recipe')
                ->click('a[href="'. env('APP_URL') .'register"]')
                ->assertSee('Create account')
                ->screenshot('guest/register-page');
        });
    }
}
