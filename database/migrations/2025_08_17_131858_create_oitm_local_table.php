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
        Schema::create('oitm_local', function (Blueprint $table) {
            $table->string('ItemCode')->primary();
            $table->string('ItemName')->nullable();
            $table->string('FrgnName')->nullable();
            $table->string('Segment')->nullable();
            $table->string('Type')->nullable();
            $table->string('Series')->nullable();
            $table->string('ProfitCenter')->nullable();
            $table->string('Brand')->nullable();
            $table->string('Satuan')->nullable();
            $table->float('TotalStock')->nullable();
            $table->float('HET')->nullable();
            $table->string('StatusHKN')->nullable();
            $table->string('StatusFG')->nullable();
            $table->text('KetHKN')->nullable();
            $table->string('KetFG')->nullable();
            $table->text('KetStock')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oitm_local');
    }
};
