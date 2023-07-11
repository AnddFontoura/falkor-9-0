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
        Schema::create('player_invitations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_player_id')->nullable(true);
            $table->unsignedBigInteger('user_id')->nullable(true);
            $table->unsignedBigInteger('team_id')->nullable(false);
            $table->string('email', 254)->nullable(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('team_player_id')->references('id')->on('team_players');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('team_id')->references('id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('player_invitations');
    }
};
