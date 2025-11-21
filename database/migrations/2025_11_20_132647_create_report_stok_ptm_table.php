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
        Schema::create('report_stok_ptm', function (Blueprint $table) {
            $table->id();
            $table->string('MAINKEY')->nullable();
            $table->string('CEK')->nullable();
            $table->string('GUDANG')->nullable();
            $table->string('ORIGINCODE')->nullable();
            $table->string('FRGNNAME')->nullable();
            $table->string('SATUAN')->nullable();
            $table->string('STOK')->nullable();
            $table->string('ESTHABISSTOKBULAN')->nullable();
            $table->string('AVG3BULAN')->nullable();
            $table->string('OPENQTYAP')->nullable();
            $table->string('STOKPLUSOPENQTY')->nullable();
            $table->string('ESTHABISSTOKPLUSOPENBULAN')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_stok_ptm');
    }
};
