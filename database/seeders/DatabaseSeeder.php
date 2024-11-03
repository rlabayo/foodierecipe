<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Profile;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            RecipeSeeder::class
        ]);

        User::create([
            'name' => 'Rhea Labayo',
            'email' => 'rdclabayo@yahoo.com',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => 'admin'
        ]);

        $users = User::all();
        
        foreach($users as $user){
            Profile::create([
                'user_id' => $user->id,
                'image' => 'assets/images/default_profile.svg',
                'thumbnail' => 'assets/images/default_profile.svg',
                'description' => 'Enter description here',
                'private' => 1
            ]);
        }

    }
}
