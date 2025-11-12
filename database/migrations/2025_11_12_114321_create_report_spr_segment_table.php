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
        Schema::create('report_spr_segment', function (Blueprint $table) {
            $table->id();
            $table->string('MAINKEY')->nullable();
            $table->string('PROFITCENTER')->nullable();
            $table->string('KEYPROFITCENTER')->nullable();
            $table->string('VALUE')->nullable();
            $table->string('TAHUN')->nullable();
            $table->string('BULAN')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_spr_segment');
    }
};
