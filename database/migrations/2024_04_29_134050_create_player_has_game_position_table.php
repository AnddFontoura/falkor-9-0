<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_has_game_position', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('player_id')->nullable(true);
            $table->unsignedBigInteger('game_position_id')->nullable(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('game_position_id')->references('id')->on('game_positions');
            $table->foreign('player_id')->references('id')->on('players');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('player_has_game_position');
    }
};
