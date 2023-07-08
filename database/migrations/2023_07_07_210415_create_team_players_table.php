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
        Schema::create('team_players', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_id')->nullable(false);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('game_position_id');
            $table->string('name', 254)->nullable(false);
            $table->string('nickname', 254)->nullable(false);
            $table->string('uniform_size');
            $table->string('photo');
            $table->integer('number');
            $table->integer('height');
            $table->integer('weight');
            $table->integer('foot_size');
            $table->integer('glove_size');
            $table->date('birthdate');
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
        Schema::dropIfExists('team_players');
    }
};
