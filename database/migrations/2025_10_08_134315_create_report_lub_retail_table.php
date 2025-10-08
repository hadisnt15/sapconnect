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
        Schema::create('report_lub_retail', function (Blueprint $table) {
            $table->id();
            $table->string('TYPE')->nullable();
            $table->string('TYPE2')->nullable();
            $table->string('LITER')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_lub_retail');
    }
};
