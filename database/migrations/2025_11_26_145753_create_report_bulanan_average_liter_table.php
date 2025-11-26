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
        Schema::create('report_bulanan_average_liter', function (Blueprint $table) {
            $table->string('MAINKEY')->primary();
            $table->string('KODECUSTOMER')->nullable();
            $table->string('NAMACUSTOMER')->nullable();
            $table->string('KODENAMACUSTOMER')->nullable();
            $table->string('SEGMENT')->nullable();
            $table->string('NO')->nullable();
            $table->string('TAHUN')->nullable();
            $table->string('BULAN')->nullable();
            $table->string('TAHUNBULAN')->nullable();
            $table->string('NAMATAHUNBULAN')->nullable();
            $table->string('LITER')->nullable();
            $table->string('STATUSORDER')->nullable();
            $table->string('KOTA')->nullable();
            $table->string('PROVINSI')->nullable();
            $table->integer('KODESALES')->nullable();
            $table->string('NAMASALES')->nullable();
            $table->integer('ROWNUM')->nullable();
            $table->string('DIVISI')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_bulanan_average_liter');
    }
};
