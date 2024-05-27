<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Field>
 */
class FieldFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'city_id' => fake()->numberBetween(1,5564),
            'name' => 'Campo '. fake()->name(),
            'address' => 'algum lugar n50',
            'google_location' => 'test'
        ];
    }
}
