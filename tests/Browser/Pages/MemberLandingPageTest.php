<?php

namespace Tests\Browser;

use App\Models\Favorite;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use PDO;
use Tests\Feature\CreateUserProfile;

class MemberLandingPageTest extends DuskTestCase
{

    /**
     * Member landing page test.
     */

    public function testGoToMemberLandingPage(): void
    {
        $user_profile = new CreateUserProfile();
        $user = $user_profile->create_user_profile();
        // $user = User::latest()->get()[0];

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/')
                ->assertSee("Shared Recipe")
                ->screenshot('member/member-landing-page');
        });
    }

    /**
     * Go to profile by clicking profile image test.
     */
    public function testGoToProfileByClickingProfileImage(): void
    {
        $user = User::latest()->get()[0];
        $recipe = Recipe::factory()->create();

        $this->browse(function (Browser $browser) use($user, $recipe) {
            $browser->loginAs($user)
                ->visit('/')
                ->assertSee('Shared Recipe')
                ->click('a[href="'. env('APP_URL') .'profile/'. $recipe->user_id .'"]')
                ->screenshot('member/go-to-profile-by-clicking-profile-image');
        });
    }

    /**
     * View recipe by clicking view button test
     */
    public function testViewRecipeByClickingViewButton(): void
    {
        $user = User::latest()->get()[0];
        $recipe = Recipe::latest()->get()[0];
        
        $this->browse(function (Browser $browser) use($user, $recipe) {
            $browser->loginAs($user)
                ->visit('/')
                ->assertSee('Shared Recipe')
                ->click('a[href="'. env('APP_URL') .'recipe/'. $recipe->id .'"]')
                ->screenshot('member/view-recipe-after-clicking-view-button');
        });
    }

    /**
     * View recipe by clicking title test
     */
    public function testViewRecipeByClickingTitle(): void
    {
        $user = User::latest()->get()[0];
        $recipe = Recipe::latest()->get()[0];

        $this->browse(function (Browser $browser) use($user, $recipe){
            $browser->loginAs($user)
                ->visit('/')
                ->assertSee('Shared Recipe')
                ->clickLink($recipe->title)
                ->screenshot('member/view-recipe-after-clicking-title');
        });
    }

    /**
     * Add and remove recipe to favorite test
     */
    public function testAddRemoveRecipeToFavorite(): void 
    {
        $user = User::latest()->get()[0];
        $recipe = Recipe::latest()->get()[0];
        
        $this->browse(function (Browser $browser1, Browser $browser2) use($user, $recipe) {
            // get the updated recipe
            $favorite_model = new Favorite();
            $is_favorite = $favorite_model->is_favorite($user->id, $recipe->id); // check if recipe is in favorite

            // Add to recipe to user's favorite
            $browser1->loginAs($user)
                ->visit('/')
                ->assertSee('Shared Recipe');

                if(!$is_favorite){
                    $browser1->click('a[href="'. env('APP_URL') .'favorite/add/'. $recipe->id .'"]')
                        ->screenshot('member/add-recipe-to-favorite');
                }

            // get the updated recipe
            $favorite_model = new Favorite();
            $is_favorite = $favorite_model->is_favorite($user->id, $recipe->id);
            
            // Remove to recipe to user's favorite
            $browser2->loginAs($user)
                ->visit('/')
                ->assertSee('Shared Recipe');
            if($is_favorite){
                $browser2->click('a[href="'. env('APP_URL') .'favorite/remove/'. $is_favorite[0]->favorite_id .'"]')
                    ->screenshot('member/remove-recipe-to-favorite');
            }
        });
    }

    /** 
     * Search test
     */
    public function testSearchItem(): void
    {
        $user = User::latest()->get()[0];

        $this->browse(function (Browser $browser) use($user){
            $browser->loginAs($user)
                ->visit('/')
                ->type('search', 'quas')
                ->click('#search_btn')
                ->screenshot('member/search-result');
        });
    }
    

    /** 
     * Go To Profile Page test
     */

     public function testGoToProfilePage(): void
     {
        $user = User::latest()->get()[0];

        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/')
                ->assertSee('Shared Recipe')
                ->clickLink('Profile')
                ->screenshot('member/go-to-profile');
        });
     }

    /** 
     * Log Out test
     */
    public function testLogOut(): void
    {
        $user = User::latest()->get()[0];

        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/')
                ->assertSee('Shared Recipe')
                ->clickLink('Log Out')
                ->screenshot('member/log-out');
        });
    }
}
