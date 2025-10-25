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
        Schema::create('report_prog_rtl', function (Blueprint $table) {
            $table->string('MAINKEY')->nullable();
            $table->string('PROGRAM')->nullable();
            $table->string('STATUS')->nullable();
            $table->string('TAHUN')->nullable();
            $table->string('BULAN')->nullable();
            $table->string('WILAYAH')->nullable();
            $table->string('MFORCE')->nullable();
            $table->string('DMS')->nullable();
            $table->string('KODECUSTOMER')->nullable();
            $table->string('NAMACUSTOMER')->nullable();
            $table->string('UUID')->nullable();
            $table->string('SEGMENT')->nullable();
            $table->string('LITER')->nullable();
            $table->string('TARGET')->nullable();
            $table->string('SISA')->nullable();
            $table->string('KETERANGAN')->nullable();
            $table->string('PERSENTASE')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_prog_rtl');
    }
};
