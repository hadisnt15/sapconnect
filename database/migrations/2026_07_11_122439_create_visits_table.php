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
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->integer('slp_code')->nullable();
            $table->foreign('slp_code')->references('SlpCode')->on('oslp_local')->nullOnDelete();
            $table->foreignId('ocrd_card_id')->nullable()->constrained('ocrd_card')->nullOnDelete();
            $table->dateTime('visit_date');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
