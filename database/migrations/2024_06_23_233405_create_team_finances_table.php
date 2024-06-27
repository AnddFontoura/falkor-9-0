<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_finances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_id')->nullable(false);
            $table->unsignedBigInteger('match_id')->nullable(true);
            $table->unsignedBigInteger('team_player_id')->nullable(true);
            $table->text('description')->nullable(true);
            $table->float('value', 10,2)->nullable(false);
            $table->integer('method')->nullable(true);
            $table->boolean('type')->default(1);
            $table->string('origin')->nullable(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_finances');
    }
};
