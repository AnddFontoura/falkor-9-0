<?php

namespace App\Console\Commands;

use App\Models\News;
use Illuminate\Console\Command;

class FakeNewsGeneratorCommand extends Command
{
    protected $signature = 'fake-data:news-factory {amount}';

    protected $description = 'Generate fake data for test';

    public function handle():void
    {
        $quantity = $this->argument('amount');

        News::factory()->count($quantity)->create();
    }
}
