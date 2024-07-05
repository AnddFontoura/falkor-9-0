<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('player_has_modality', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('player_id')->nullable(true);
            $table->unsignedBigInteger('modality_id')->nullable(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('modality_id')->references('id')->on('modalities');
            $table->foreign('player_id')->references('id')->on('players');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('player_has_modality');
    }
};
