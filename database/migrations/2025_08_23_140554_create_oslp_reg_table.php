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
        Schema::create('oslp_reg', function (Blueprint $table) {
            $table->id();
            $table->string('RegUserId')->unique();
            $table->integer('RegSlpCode')->unique();
            $table->foreign('RegSlpCode')->references('SlpCode')->on('oslp_local');
            $table->string('Alias')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oslp_reg');
    }
};
