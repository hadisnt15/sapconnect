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
        Schema::create('report_kontrak_ids', function (Blueprint $table) {
            $table->id();
            $table->string('MAINKEY')->unique();
            $table->string('GRUP');
            $table->date('TANGGAL');
            $table->string('KET1');
            $table->string('KET2');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_kontrak_ids');
    }
};
