<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('friendly_games', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_id');
            $table->unsignedBigInteger('city_id');
            $table->text('description');
            $table->float('price')
                ->nullable(false)
                ->default(200);
            $table->date('match_date');
            $table->string('start_at');
            $table->string('duration');
            $table->boolean('defined')
                ->default(0);
            $table->string('main_uniform_color')
                ->nullable(true);
            $table->string('secondary_uniform_color')
                ->nullable(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('team_id')
                ->references('id')
                ->on('teams');

            $table->foreign('city_id')
                ->references('id')
                ->on('cities');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('friendly_games');
    }
};
