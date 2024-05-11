<?php

namespace App\Console\Commands;

use App\Models\Player;
use Illuminate\Console\Command;

class FakePlayerGeneratorCommand extends Command
{
    protected $signature = 'fake-data:player-factory {amount}';

    protected $description = 'Generate fake data for test';

    public function handle()
    {
        $quantity = $this->argument('amount');

        Player::factory()->count($quantity)->create();
    }
}
