<?php

namespace App\Console\Commands;

use App\Models\Field;
use Illuminate\Console\Command;

class FakeFieldGeneratorCommand extends Command
{    
    protected $signature = 'fake-data:field-factory {amount}';

    protected $description = 'Generate fake data for test';

    public function handle()
    {
        $quantity = $this->argument('amount');

        Field::factory()->count($quantity)->create();
    }
}
