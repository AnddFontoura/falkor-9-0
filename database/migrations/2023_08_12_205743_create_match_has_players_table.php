<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('match_has_players', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('match_id');
            $table->unsignedBigInteger('team_player_id');
            $table->unsignedBigInteger('game_position_id')->nullable(true);
            $table->integer('number')->nullable(true);
            $table->boolean('invited')->default(1);
            $table->boolean('confirmed')->default(0);
            $table->boolean('showed_up')->default(0);
            $table->text('reason_for_absence', 1000)->nullable(true);
            $table->float('price_payed', 6,2)->default(0.00);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('match_id')->references('id')->on('matches');
            $table->foreign('team_player_id')->references('id')->on('team_players');
            $table->foreign('game_position_id')->references('id')->on('game_positions');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('match_has_players');
    }
};
