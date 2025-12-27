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
        Schema::create('report_pembelian_harian', function (Blueprint $table) {
            $table->string('MAINKEY');
            $table->date('TANGGAL');
            $table->string('TIPE');
            $table->string('KETPERIODE');
            $table->string('SEGMENT');
            $table->string('LITER');
            $table->string('KILOLITER');
            $table->string('KETQTYUOM');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_pembelian_harian');
    }
};
