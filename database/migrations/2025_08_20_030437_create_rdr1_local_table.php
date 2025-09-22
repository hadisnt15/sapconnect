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
        Schema::create('rdr1_local', function (Blueprint $table) {
            $table->id();
            $table->integer('OdrId');
            $table->foreign('OdrId')->references('id')->on('ordr_local');
            $table->string('RdrItemCode');
            $table->foreign('RdrItemCode')->references('ItemCode')->on('oitm_local');
            $table->float('RdrItemQuantity');
            $table->string('RdrItemSatuan');
            $table->float('RdrItemPrice');
            $table->string('RdrItemProfitCenter');
            $table->string('RdrItemKetHKN');
            $table->string('RdrItemKetFG');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rdr1_local');
    }
};
