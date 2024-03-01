<?php

namespace Tests\Browser\Pages;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Common;
use Tests\DuskTestCase;

class ProfilePageTest extends DuskTestCase
{
    /**
     * View profile page test
     */
    public function testViewProfilePage(): void
    {
        $user = User::where('email', 'rdclabayo@yahoo.com')->get()[0];

        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/profile')
                ->assertSee($user->name)
                ->screenshot('profile/view-profile-page');
        });
    }

    /**
     * View edit profile page
     */

    public function testViewEditProfilePage(): void
    {
        $user = User::where('email', 'rdclabayo@yahoo.com')->get()[0];

        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/profile')
                ->click('a[href="'. env('APP_URL') .'profile/user/edit"]')
                ->assertSee('Profile Avatar');

                // call function for full page screenshot
                $common = new Common();
                $common->full_page_screenshot($browser); 
                $browser->screenshot('profile/edit-profile-page');
                // ->responsiveScreenshots('profile/edit-profile-page-responsive')
                // ->screenshot('profile/edit-profile-page');
        });
    }

    /**
     * Click post tab test
     */

    public function testClickPostTab(): void
    {
        $user = User::where('email', 'rdclabayo@yahoo.com')->get()[0];

        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/profile')
                ->assertSee($user->name)
                ->clickLink('posts')
                ->screenshot('profile/post-page');
        });
    }

    /**
     * Click favorite tab test
     */
    public function testClickFavoriteTab(): void
    {
        $user = User::where('email', 'rdclabayo@yahoo.com')->get()[0];

        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/profile')
                ->assertSee($user->name)
                ->clickLink('favorites')
                ->screenshot('profile/favorite-page');
        });
    }

    /**
     * Click followers tab test
     */
    public function testClickFollowersTab(): void
    {
        $user = User::where('email', 'rdclabayo@yahoo.com')->get()[0];

        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/profile')
                ->assertSee($user->name)
                ->clickLink('followers')
                ->screenshot('profile/followers-page');
        });
    }

    /**
     * Click following tab test
     */
    public function testClickFollowingTab(): void
    {
        $user = User::where('email', 'rdclabayo@yahoo.com')->get()[0];

        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/profile')
                ->assertSee($user->name)
                ->clickLink('following')
                ->screenshot('profile/following-page');
        });
    }

    /**
     * Go to create recipe page
     */

    public function testGoToCreateRecipePage(): void 
    {
        $user = User::where('email', 'rdclabayo@yahoo.com')->get()[0];

        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/profile')
                ->assertSee($user->name)
                ->press('CREATE RECIPE')
                ->screenshot('profile/create-recipe-page');
        });
    }

    /**
     * View recipe after clicking view button
     */

     public function testClickViewRecipeButton(): void
     {
        $user = User::where('email', 'rdclabayo@yahoo.com')->get()[0];
        $recipe = Recipe::latest()->limit(1)->where('user_id', $user->id)->get();

        $this->browse(function (Browser $browser) use($user, $recipe) {
            $browser->loginAs($user)
                ->visit('/profile')
                ->assertSee($user->name);

                if($recipe->count() > 0){
                    $browser->click('a[href="'. env('APP_URL') .'recipe/'. $recipe[0]->id .'"]')
                        ->screenshot('profile/show-recipe-after-clicking-view-button');
                }
        });
     }

    /**
     * View recipe after clicking title 
     */

     public function testClickViewRecipeTitle(): void
     {
        $user = User::where('email', 'rdclabayo@yahoo.com')->get()[0];
        $recipe = Recipe::latest()->limit(1)->where('user_id', $user->id)->get();

        $this->browse(function (Browser $browser) use($user, $recipe) {
            $browser->loginAs($user)
                ->visit('/profile')
                ->assertSee($user->name);

                if($recipe->count() > 0){
                    $browser->clickLink($recipe[0]->title)
                        ->screenshot('profile/show-recipe-after-clicking-recipe-title');
                }
        });
     }

    /**
     * Go to edit recipe page
     */
    public function testGoToEditRecipePage(): void
    {
        $user = User::where('email', 'rdclabayo@yahoo.com')->get()[0];
        $recipe = Recipe::latest()->limit(1)->where('user_id', $user->id)->get();

        $this->browse(function (Browser $browser) use($user, $recipe) {
            $browser->loginAs($user)
                ->visit('/profile')
                ->assertSee($user->name);

                if($recipe->count() > 0){
                    $browser->click('a[href="'. env('APP_URL') .'recipe/'. $recipe[0]->id .'/edit"]');

                    $common = new Common();
                    $common->full_page_screenshot($browser);
                    $browser->screenshot('profile/go-to-edit-recipe-page');
                }
        });
    }
    
    /**
     * Click delete button to delete recipe
     */

    public function testClickDeleteRecipe(): void
    {
        // $user = User::where('email', 'rdclabayo@yahoo.com')->get()[0];
        // $recipe = Recipe::latest()->limit(1)->where('user_id', $user->id)->get();

        // $this->browse(function (Browser $browser) use($user, $recipe) {
        //     $browser->loginAs($user)
        //         ->visit('/profile')
        //         ->assertSee($user->name);


        // });
    }
}
