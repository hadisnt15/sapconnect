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
        Schema::create('report_jadwal_pengisian_ibc', function (Blueprint $table) {
            $table->string('MAINKEY');
            $table->date('FILLINGDATE');
            $table->string('ORIGINCODE');
            $table->string('FRGNNAME');
            $table->string('QTY');
            $table->string('UOM');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_jadwal_pengisian_ibc');
    }
};
