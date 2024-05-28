<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name', 254)->nullable(false);
            $table->text('description')->nullable(true);
            $table->string('slug', 254)->nullable(false);
            $table->integer('duration_days')->nullable(true);
            $table->integer('durations_months')->nullable(true);
            $table->float('price', 12, 2)->default(999.99);
            $table->jsonb('features')->nullable(true);
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
};
