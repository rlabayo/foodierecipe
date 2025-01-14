<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Libraries\ImageLibrary;
use App\Models\Recipe;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Recipe::class;

    public function definition(): array
    {
        // $user = User::factory()->create();

        $data = [
            'user_id' => 1,
            'title' => $this->faker->words(3, true),
            'summary' => $this->faker->words(20, true),
            'ingredients' => '[{"item":"ingredient 1"},{"item":"ingredient 2"},{"item":"ingredient 3"}]',
            'instruction' => '[{"instruction_item":"test instruction","attached_photo":""}]',
            'video_url' => '',
            'private' => 0,
            'image' => 'assets/images/default.png',
            'thumbnail' => 'assets/images/default.png',
            // 'image' => $this->faker->imageUrl(640, 480, true),
            // 'thumbnail' => $this->faker->imageUrl(640, 480, true),
            ];

        return $data;
    }
}
