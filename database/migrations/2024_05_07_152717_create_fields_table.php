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
        Schema::create('fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('city_id');
            $table->string('name')->unique();
            $table->text('nickname')->nullable();
            $table->string('address');
            $table->string('google_location');
            $table->string('owner');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('city_id')->references('id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('fields', function(Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['city_id']);
            $table->dropSoftDeletes();
        });

        Schema::dropIfExists('fields');
    }
};
