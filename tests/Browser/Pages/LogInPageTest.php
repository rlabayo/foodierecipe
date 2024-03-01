<?php

namespace Tests\Browser\Pages;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\Feature\CreateUserProfile;

class LogInPageTest extends DuskTestCase
{
    /**
     * View log in page test
     */
    public function testViewLogInPage(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertSee('Log In')
                    ->screenshot('login/view-login-page');
        });
    }

    /**
     * Go to create account / register page test
     */
    public function testGoToCreateAccount(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->assertSee('Log In')
                ->click('a[href="'. env('APP_URL') .'register"]')
                ->screenshot('login/go-to-register-page');
        });
    }

    /**
     * Try to login test
     */
    public function testTryToLogin(): void
    {
        $user_profile = new CreateUserProfile();
        $user = $user_profile->create_user_profile();

        $this->browse(function (Browser $browser) use($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->screenshot('login/login-form-filled-data')
                ->press('LOG IN')
                ->screenshot('/login/login-user');
        });
    }

}
