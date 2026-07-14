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
        Schema::create('ocrd_card', function (Blueprint $table) {
            $table->id();
            $table->string('card_code')->nullable();
            $table->foreign('card_code')->references('CardCode')->on('ocrd_local')->nullOnDelete();
            $table->string('card_name')->nullable();
            $table->string('segment')->nullable();
            $table->text('office_address')->nullable();
            $table->decimal('office_lat', 10, 7)->nullable();
            $table->decimal('office_lng', 10, 7)->nullable();
            $table->string('office_phone')->nullable();
            $table->string('office_mail')->nullable();
            $table->string('office_fax')->nullable();
            $table->text('site_address')->nullable();
            $table->decimal('site_lat', 10, 7)->nullable();
            $table->decimal('site_lng', 10, 7)->nullable();
            $table->string('site_phone')->nullable();
            $table->string('site_mail')->nullable();
            $table->string('site_fax')->nullable();
            $table->longText('customer_desc')->nullable();
            $table->longText('service_desc')->nullable();
            $table->longText('competitor_desc')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ocrd_card');
    }
};
