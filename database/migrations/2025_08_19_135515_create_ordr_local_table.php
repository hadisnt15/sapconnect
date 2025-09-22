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
        Schema::create('ordr_local', function (Blueprint $table) {
            $table->id();
            $table->string('OdrRefNum')->unique();
            $table->integer('OdrNum');
            $table->string('OdrCrdCode');
            $table->foreign('OdrCrdCode')->references('CardCode')->on('ocrd_local');
            $table->string('OdrSlpCode');
            $table->foreign('OdrSlpCode')->references('SlpCode')->on('oslp_local');
            $table->dateTime('OdrDocDate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordr_local');
    }
};
