<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_players', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_id')->nullable(false);
            $table->unsignedBigInteger('user_id')->nullable(true);
            $table->unsignedBigInteger('game_position_id');
            $table->string('name', 254)->nullable(false);
            $table->string('nickname', 254)->nullable(false);
            $table->string('uniform_size')->nullable(true);
            $table->string('photo')->nullable(true);
            $table->integer('number')->nullable(true);
            $table->integer('height')->nullable(true);
            $table->integer('weight')->nullable(true);
            $table->integer('foot_size')->nullable(true);
            $table->integer('glove_size')->nullable(true);
            $table->date('birthdate')->nullable(true);
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('team_id')->references('id')->on('teams');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('game_position_id')->references('id')->on('game_positions');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_players');
    }
};
