<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MatchesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $cityId = City::inRandomOrder()->first();
        $visitorTeam = Team::inRandomOrder()->first();
        do {
            $homeTeam = Team::inRandomOrder()->first();
        } while ($visitorTeam->id == $homeTeam->id);

        return [
            'created_by_team_id' => rand(0,1) ? $visitorTeam->id : $homeTeam->id,
            'championship_id' => null,
            'visitor_team_id' => $visitorTeam->id,
            'home_team_id' => $homeTeam->id,
            'field_id' => null,
            'city_id' => $cityId,
            'championship_name' => null,
            'visitor_team_name' => $visitorTeam->name,
            'home_team_name' => $homeTeam->name,
            'visitor_score' => rand(0,10),
            'home_score' => rand(0, 10),
            'location' => $this->faker->address(),
            'schedule' => $this->faker->date(),
        ];
    }
}
