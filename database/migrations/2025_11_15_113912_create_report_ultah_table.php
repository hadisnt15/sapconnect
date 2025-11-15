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
            $table->string('kode_cust')->nullable();
            $table->string('nama_cust')->nullable();
            $table->string('nama_pemilik')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('kota')->nullable();
            $table->string('kode_sales')->nullable();
            $table->string('nama_sales')->nullable();
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
