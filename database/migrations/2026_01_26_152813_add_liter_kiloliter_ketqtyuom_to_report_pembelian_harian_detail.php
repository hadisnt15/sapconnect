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
        Schema::table('report_pembelian_harian_detail', function (Blueprint $table) {
            $table->string('LITER');
            $table->string('KILOLITER');
            $table->string('KETQTYUOM');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('report_pembelian_harian_detail', function (Blueprint $table) {
            //
        });
    }
};
