<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('city_id');
            $table->string('slug', 500)->nullable(true);
            $table->string('name', 500);
            $table->text('description', 10000);
            $table->date('foundation_date')->nullable(true);
            $table->string('logo_path', 1000)->nullable(true);
            $table->string('banner_path', 1000)->nullable(true);
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
