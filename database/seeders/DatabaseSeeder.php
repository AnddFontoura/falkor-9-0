<?php

namespace Database\Seeders;

use App\Models\GamePosition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            StateSeeder::class,
            CitySeeder::class,
            GamePosition::class,
        ]);
    }
}
