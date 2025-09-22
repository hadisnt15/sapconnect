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
        Schema::create('dashboard', function (Blueprint $table) {
            $table->string('MAINKEY')->primary();
            $table->integer('DOCENTRY')->nullable();
            $table->integer('KODESALES')->nullable();
            $table->string('NAMASALES')->nullable();
            $table->string('KEY')->nullable();
            $table->string('KEY2')->nullable();
            $table->string('KEY3')->nullable();
            $table->string('KEY4')->nullable();
            $table->string('TYPE')->nullable();
            $table->string('TARGET')->nullable();
            $table->string('CAPAI')->nullable();
            $table->string('PERSENTASE')->nullable();
            $table->string('TARGETSPR')->nullable();
            $table->string('CAPAISPR')->nullable();
            $table->string('SUMTARGETSPR')->nullable();
            $table->string('SUMCAPAISPR')->nullable();
            $table->string('SUMPERSENTASE')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dashboard');
    }
};
