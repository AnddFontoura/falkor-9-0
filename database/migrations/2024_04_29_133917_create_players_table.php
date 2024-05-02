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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(true);
            $table->unsignedBigInteger('city_id')->nullable(true);
            $table->string('name', 254)->nullable(false);
            $table->string('nickname', 254)->nullable(false);
            $table->string('uniform_size')->nullable(true);
            $table->string('photo')->nullable(true);
            $table->integer('height')->nullable(true);
            $table->integer('weight')->nullable(true);
            $table->integer('foot_size')->nullable(true);
            $table->integer('glove_size')->nullable(true);
            $table->date('birthdate')->nullable(true);
            $table->boolean('status')->default(false);
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('players');
    }
};
