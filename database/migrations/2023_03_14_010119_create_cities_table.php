<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('state_id')->nullable(false);
            $table->string('name', 200)->nullable(false);
            $table->string('ibge_code', 200)->nullable(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('state_id')->references('id')->on('states');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
