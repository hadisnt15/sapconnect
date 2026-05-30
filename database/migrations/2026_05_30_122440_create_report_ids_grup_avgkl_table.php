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
        Schema::create('report_ids_grup_avgkl', function (Blueprint $table) {
            $table->string('MAINKEY')->nullable();
            $table->string('TYPECUST')->nullable();
            $table->string('GROUPCUST')->nullable();
            $table->string('TAHUN')->nullable();
            $table->string('BULAN')->nullable();
            $table->string('ORIGINCODE')->nullable();
            $table->string('FRGNNAME')->nullable();
            $table->string('AVGKL')->nullable();
            $table->string('RANK')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_ids_grup_avgkl');
    }
};
