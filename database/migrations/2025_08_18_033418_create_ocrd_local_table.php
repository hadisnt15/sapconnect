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
        Schema::create('ocrd_local', function (Blueprint $table) {
            $table->id();
            $table->string('CardCode')->unique();
            $table->string('CardName')->nullable();
            $table->string('Address')->nullable();
            $table->string('City')->nullable();
            $table->string('State')->nullable();
            $table->string('Contact')->nullable();
            $table->string('Phone')->nullable();
            $table->string('Group')->nullable();
            $table->string('Type1')->nullable();
            $table->string('Type2')->nullable();
            $table->date('CreateDate')->nullable();
            $table->date('LastOdrDate')->nullable();
            $table->string('Termin')->nullable();
            $table->float('Limit')->nullable();
            $table->float('ActBal')->nullable();
            $table->float('DlvBal')->nullable();
            $table->float('OdrBal')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ocrd_local');
    }
};
