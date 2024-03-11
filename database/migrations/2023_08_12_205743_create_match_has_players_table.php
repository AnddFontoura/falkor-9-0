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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('match_has_players');
    }
};
