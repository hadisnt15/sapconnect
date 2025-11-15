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
        Schema::create('report_ultah', function (Blueprint $table) {
            $table->id();
            $table->string('MAINKEY')->nullable();
            $table->string('KODECUST')->nullable();
            $table->string('NAMACUST')->nullable();
            $table->string('PEMILIK')->nullable();
            $table->date('ULTAH')->nullable();
            $table->string('KOTA')->nullable();
            $table->string('KODESALES')->nullable();
            $table->string('NAMASALES')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_ultah');
    }
};
