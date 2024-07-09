<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('player_id')
                ->nullable(false);
            $table->unsignedBigInteger('team_id')
                ->nullable(false);
            $table->unsignedBigInteger('game_position_id')
                ->nullable(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('team_id')
                ->references('id')
                ->on('teams');

            $table->foreign('game_position_id')
                ->references('id')
                ->on('game_positions');

            $table->foreign('player_id')
                ->references('id')
                ->on('players');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_applications');
    }
};
