<?php

namespace App\Console\Commands;

use App\Models\Team;
use Illuminate\Console\Command;

class FakeTeamGeneratorCommand extends Command
{
    protected $signature = 'fake-data:team-factory {amount}';

    protected $description = 'Generate fake data for test';

    public function handle()
    {
        $quantity = $this->argument('amount');

        Team::factory()->count($quantity)->create();
    }
}
