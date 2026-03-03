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
        Schema::table('odln_local', function (Blueprint $table) {
            $table->string('kode_customer')->after('waktu_input');
            $table->string('nama_customer')->after('waktu_input');
            $table->string('freegood')->after('waktu_input');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('odln_local', function (Blueprint $table) {
            //
        });
    }
};
