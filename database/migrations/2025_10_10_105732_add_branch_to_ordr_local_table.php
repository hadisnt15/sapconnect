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
        Schema::table('ordr_local', function (Blueprint $table) {
            $table->enum('branch',['HO','BJN','BTL','SPT','PLB','PLK']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ordr_local', function (Blueprint $table) {
            //
        });
    }
};
