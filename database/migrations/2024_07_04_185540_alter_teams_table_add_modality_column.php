<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('teams', function (Blueprint $table) {
           $table->unsignedBigInteger('modality_id')->nullable(true)->after('id');

           $table->foreign('modality_id')->references('id')->on('modalities');
        });
    }

    public function down(): void
    {
        Schema::table('teams', function (Blueprint $table) {

        });
    }
};
