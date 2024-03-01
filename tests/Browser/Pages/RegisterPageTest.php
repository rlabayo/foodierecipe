<?php

namespace Tests\Browser\Pages;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterPageTest extends DuskTestCase
{
    /**
     * Register user test
     */
    public function testRegisterUser(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('name', fake()->name())
                ->type('email', fake()->unique()->safeEmail())
                ->type('password', 'password')
                ->type('password_confirmation', 'password')
                ->screenshot('register/register-form-filled-data')
                ->press('REGISTER')
                ->screenshot('register/register-user');
        });
    }
}
