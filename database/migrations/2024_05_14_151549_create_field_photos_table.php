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
        Schema::create('field_photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('field_id');
            $table->boolean('main')->default(1);
            $table->text('photo', 254);
            $table->timestamps();
            
            $table->foreign('field_id')->references('id')->on('fields');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('field_photos', function (Blueprint $table) {
            $table->dropForeign(['field_id']);
        });

        Schema::dropIfExists('field_photos');
    }
};
