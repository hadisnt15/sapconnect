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
        Schema::table('ocrd_person', function (Blueprint $table) {
            $table->string('religion')->nullable()->after('hobby');
            $table->enum('gender', ['Laki-laki','Perempuan'])->nullable()->after('hobby');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ocrd_person', function (Blueprint $table) {
            //
        });
    }
};
