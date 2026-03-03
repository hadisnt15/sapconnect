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
        Schema::create('odln_local', function (Blueprint $table) {
            $table->id();
            $table->string('ref_sj')->unique();
            $table->string('no_sj')->unique();
            $table->date('tgl_sj');
            $table->date('tgl_input');
            $table->string('waktu_input');
            $table->boolean('is_checked')->default(0);
            $table->boolean('is_synced')->default(0);
            $table->text('ket');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('odln_local');
    }
};
