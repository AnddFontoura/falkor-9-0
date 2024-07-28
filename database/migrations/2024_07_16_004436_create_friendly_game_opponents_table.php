<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('friendly_game_opponents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('friendly_game_id');
            $table->unsignedBigInteger('opponent_id');
            $table->boolean('selected')->default(false);
            $table->string('main_uniform_color')
                ->nullable(true);
            $table->string('secondary_uniform_color')
                ->nullable(true);
            $table->integer('proposal_team_status')->default(0);
            $table->integer('opponent_team_status')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('opponent_id')
                ->references('id')
                ->on('teams');

            $table->foreign('friendly_game_id')
                ->references('id')
                ->on('friendly_games');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('friendly_game_opponents');
    }
};
