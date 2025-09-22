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
        Schema::table('rdr1_local', function (Blueprint $table) {
            $table->decimal('RdrItemDisc', 10, 2)
                  ->default(0)
                  ->nullable(false)
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rdr1_local', function (Blueprint $table) {
            $table->decimal('RdrItemDisc', 10, 2)
                  ->default(0)
                  ->nullable(false)
                  ->change();
        });
    }
};
