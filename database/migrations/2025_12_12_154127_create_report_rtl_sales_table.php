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
        Schema::create('report_rtl_sales', function (Blueprint $table) {
            $table->id();
            $table->string('MAINKEY')->nullable();
            $table->integer('SLPCODE')->nullable();
            $table->string('SLPNAME')->nullable();
            $table->string('TAHUN')->nullable();
            $table->string('BULAN')->nullable();
            $table->string('SEGMENT')->nullable();
            $table->string('TARGET')->nullable();
            $table->string('LITER')->nullable();
            $table->string('PERSEN')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_rtl_sales');
    }
};
