<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by_team_id')->nullable(true);
            $table->unsignedBigInteger('championship_id')->nullable(true);
            $table->unsignedBigInteger('visitor_team_id')->nullable(true);
            $table->unsignedBigInteger('home_team_id')->nullable(true);
            $table->unsignedBigInteger('field_id')->nullable(true);
            $table->unsignedBigInteger('city_id')->nullable(false);
            $table->string('championship_name', 254)->nullable(true);
            $table->string('visitor_team_name', 254)->nullable(true);
            $table->string('home_team_name', 254)->nullable(true);
            $table->integer('visitor_score')->nullable(true);
            $table->integer('home_score')->nullable(true);
            $table->text('location');
            $table->datetime('schedule')->nullable(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by_team_id')->references('id')->on('teams');
            $table->foreign('visitor_team_id')->references('id')->on('teams');
            $table->foreign('home_team_id')->references('id')->on('teams');
            $table->foreign('city_id')->references('id')->on('cities');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
