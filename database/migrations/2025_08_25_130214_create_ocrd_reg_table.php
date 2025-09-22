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
        Schema::create('ocrd_reg', function (Blueprint $table) {
            $table->id();
            $table->string('RegCardCode')->unique();
            $table->string('RegCardName');
            $table->text('RegAddress');
            $table->string('RegState');
            $table->string('RegCity');
            $table->string('RegContact');
            $table->string('RegPhone');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ocrd_reg');
    }
};
