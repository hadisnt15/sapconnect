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
        Schema::create('report_piutang_45hari', function (Blueprint $table) {
            $table->string('KODECUST');
            $table->string('NAMACUST');
            $table->string('JENISCUST');
            $table->string('GOLONGANCUST');
            $table->string('KEY');
            $table->string('CABANG');
            $table->string('LEWATHARI');
            $table->string('KET');
            $table->string('KET2');
            $table->string('PIUTANG');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_piutang_45hari');
    }
};
