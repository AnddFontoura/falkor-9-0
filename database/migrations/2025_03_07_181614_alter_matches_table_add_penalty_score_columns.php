<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('matches', function (Blueprint $table) {
            $table->boolean('has_penalties')->default(false);
            $table->integer('visitor_penalty_score')->nullable(true);
            $table->integer('home_penalty_score')->nullable(true);
        });
    }

    public function down(): void
    {
        Schema::table('matches', function (Blueprint $table) {
            $table->dropColumn('has_penalties');
            $table->dropColumn('visitor_penalty_score');
            $table->dropColumn('home_penalty_score');
        });
    }
};
