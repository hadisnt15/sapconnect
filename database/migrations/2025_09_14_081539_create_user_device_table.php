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
        Schema::create('user_devices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('device_id')->index(); // id unik device (hash)
            $table->string('device')->nullable();  // device name (agent->device())
            $table->string('platform')->nullable();
            $table->string('browser')->nullable();
            $table->string('ip')->nullable();
            $table->timestamp('last_active')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'device_id']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_device');
    }
};
