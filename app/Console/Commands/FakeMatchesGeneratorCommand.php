<?php

namespace App\Console\Commands;

use App\Models\Matches;
use Illuminate\Console\Command;

class FakeMatchesGeneratorCommand extends Command
{
    protected $signature = 'fake-data:matches-factory {amount}';

    protected $description = 'Generate fake data for test';

    public function handle()
    {
        $quantity = $this->argument('amount');

        Matches::factory()->count($quantity)->create();
    }
}
