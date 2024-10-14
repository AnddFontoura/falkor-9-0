<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('players', function (Blueprint $table) {
            $table->unsignedBigInteger('birth_city_id')->nullable(true);

            $table->foreign('birth_city_id')->references('id')->on('cities');
        });
    }

    public function down(): void
    {
        Schema::table('players', function (Blueprint $table) {
            $table->dropForeign('players_birth_city_id_foreign');
            $table->dropColumn('birth_city_id');
        });
    }
};
