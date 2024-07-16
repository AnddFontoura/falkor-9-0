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
            $table->unsignedBigInteger('opponent_id');
            $table->boolean('selected')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('opponent_id')
                ->references('id')
                ->on('teams');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('friendly_game_opponents');
    }
};
