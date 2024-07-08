<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::where('is_admin', true)->inRandomOrder()->first(),
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraph(rand(1,9)),
            'header_image' => $this->faker->imageUrl(),
        ];
    }
}
