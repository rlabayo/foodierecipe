<?php

namespace Tests\Browser\Pages;

use App\Models\Favorite;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ShowRecipePageTest extends DuskTestCase
{
    /**
     * View show recipe page
     */
    public function testViewShowRecipePage(): void
    {
        $user = User::where('email', 'rdclabayo@yahoo.com')->get()[0];
        $recipe = Recipe::latest()->limit(1)->get();

        $this->browse(function (Browser $browser) use($user, $recipe) {
            $browser->loginAs($user)
                ->visit('/recipe')
                ->clickLink($recipe[0]->title)
                ->assertSee($recipe[0]->title)
                ->screenshot('recipe/show-recipe-page');
        });
    }

    /**
     * Edit Recipe test
     */
    public function testEditRecipe(): void 
    {
        $user = User::where('email', 'rdclabayo@yahoo.com')->get()[0];
        $recipe = Recipe::latest()->limit(1)->where('user_id', $user->id)->get();

        $this->browse(function (Browser $browser) use($user, $recipe) {
            $browser->loginAs($user)
                ->visit("/recipe/" .$recipe[0]->id)
                ->assertSee($recipe[0]->title)
                ->click('a[href="'. env('APP_URL') .'recipe/'. $recipe[0]->id .'/edit"]')
                ->screenshot('recipe/edit-recipe-page');
            
        });
    }

    /**
     * Delete Recipe test
     */
    public function testDeleteRecipe(): void 
    {
        $user = User::where('email', 'rdclabayo@yahoo.com')->get()[0];
        $recipe = Recipe::latest()->limit(1)->where('user_id', $user->id)->get();

        $this->browse(function (Browser $browser) use($user, $recipe) {
            $browser->loginAs($user)
                ->visit("/recipe/" .$recipe[0]->id)
                ->assertSee($recipe[0]->title);
                // ->click('a[href="'. env('APP_URL') .'recipe/'. $recipe[0]->id .'/edit"]') // delete recipe
                // ->screenshot('recipe/edit-recipe-page');
        });
    }

    /**
     * Add favorite recipe test
     */
    public function testAddFavoriteRecipe(): void 
    {
        $user = User::where('email', 'rdclabayo@yahoo.com')->get()[0];
        $recipe = Recipe::latest()->limit(1)->get();

        $this->browse(function (Browser $browser) use($user, $recipe) {
            $browser->loginAs($user)
                ->visit('/recipe')
                ->clickLink($recipe[0]->title)
                ->assertSee($recipe[0]->title);
                
            // Check if user posted the recipe
            if($user->id != $recipe[0]->user_id){
                $favorite_model = new Favorite();
                // Add recipe to favorite
                $is_favorite = $favorite_model->is_favorite($user->id, $recipe[0]->id);

                if(!$is_favorite)
                {
                    $browser->clickLink('+')
                        ->screenshot('recipe/added-recipe-to-favorite');
                }
            }
        });
    }

    /**
     * Remove favorite test
     */
    public function testRemoveFavoriteRecipe(): void 
    {
        $user = User::where('email', 'rdclabayo@yahoo.com')->get()[0];
        $recipe = Recipe::latest()->limit(1)->get();

        $this->browse(function (Browser $browser) use($user, $recipe) {
            $browser->loginAs($user)
                ->visit('/recipe')
                ->clickLink($recipe[0]->title)
                ->assertSee($recipe[0]->title);
                
            // Check if user posted the recipe
            if($user->id != $recipe[0]->user_id){
                $favorite_model = new Favorite();

                // Remove recipe to favorite
                $is_favorite = $favorite_model->is_favorite($user->id, $recipe[0]->id);
                if($is_favorite->count() > 0)
                {
                    $browser->click('a[href="'. env('APP_URL') .'favorite/remove/'. $is_favorite[0]->favorite_id .'"]')
                        ->screenshot('recipe/removed-recipe-to-favorite');
                }
            }
        });
    }

    /**
     * Recommendation list test
     */


    /**
     * Submit comment test
     */


    /**
     * Edit comment test
     */


    /**
     * Delete comment test
     */
    
}
