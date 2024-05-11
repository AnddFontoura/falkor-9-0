<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        rand(0,1) ? $userId = User::factory()->create()->id 
            : $userId = User::inRandomOrder()->first()->id;

        $name = $this->faker->name();
        $cityId = City::inRandomOrder()->first();

        return [
            'user_id' => $userId,
            'city_id' => $cityId,
            'slug' => Str::slug($name),
            'name' => $name,
            'description' => $this->faker->text(1000),
            'foundation_date' => $this->faker->date(),
            'logo_path' => null,
            'banner_path' => null,
        ];
    }
}
