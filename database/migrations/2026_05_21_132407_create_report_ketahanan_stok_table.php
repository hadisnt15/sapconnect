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
        Schema::create('report_ketahanan_stok', function (Blueprint $table) {
            $table->string('MAINKEY');
            $table->date('TANGGAL');
            $table->string('ORIGINCODE');
            $table->string('FRGNNAME');
            $table->string('UOM');
            $table->string('STOCKONHAND');
            $table->string('STOCKOUTSTANDING');
            $table->string('STOCKCONTAINER');
            $table->string('STOCKRENCANAISI');
            $table->string('STOCKRENCANAJADWAL');
            $table->string('TOTALSTOCK');
            $table->string('STOCKPINJAMMADHANI');
            $table->string('STOCKPINJAMPPA');
            $table->string('TOTALSTOCKPINJAM');
            $table->string('SISASTOCK');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ketahanan_stok');
    }
};
