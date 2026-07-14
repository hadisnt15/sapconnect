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
        Schema::create('ocrd_equipment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ocrd_card_id')->nullable()->constrained('ocrd_card')->nullOnDelete();
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->string('capacity')->nullable();
            $table->string('sump_tank')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ocrd_equipment');
    }
};
