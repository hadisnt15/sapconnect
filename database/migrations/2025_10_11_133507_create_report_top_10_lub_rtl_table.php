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
        Schema::create('report_top_10_lub_rtl', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('cardcode');
            $table->string('cardname');
            $table->float('liter');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_top_10_lub_rtl');
    }
};
