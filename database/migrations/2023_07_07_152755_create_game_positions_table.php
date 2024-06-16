<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('game_positions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100)->nullable(false);
            $table->string('short', 10)->nullable(false);
            $table->string('description', 10000)->nullable(true);
            $table->string('icon', 500)->nullable(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_positions');
    }
};
