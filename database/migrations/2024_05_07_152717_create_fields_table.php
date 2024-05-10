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
            $table->unsignedBigInteger('city_id');
            $table->string('name', 254);
            $table->text('nickname', 1000)->nullable();
            $table->text('address', 1000);
            $table->string('google_location', 254);
            $table->timestamps();
            $table->softDeletes();
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
            $table->dropForeign(['city_id']);
        });

        Schema::dropIfExists('fields');
    }
};
