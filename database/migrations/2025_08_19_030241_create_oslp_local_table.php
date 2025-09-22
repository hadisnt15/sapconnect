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
        Schema::create('oslp_local', function (Blueprint $table) {
            $table->integer('SlpCode')->primary();
            $table->string('SlpName');
            $table->string('Phone')->nullable();
            $table->date('FirstOdrDate')->nullable();
            $table->date('LastOdrDate')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oslp_local');
    }
};
