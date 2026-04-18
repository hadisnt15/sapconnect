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
        Schema::create('odln_re_local', function (Blueprint $table) {
            $table->id();
            $table->string('no_sj');
            $table->foreign('no_sj')->references('no_sj')->on('odln_local');
            $table->boolean('is_checked')->default(0);
            $table->boolean('is_synced')->default(0);
            $table->text('ket')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('odln_re_local');
    }
};
