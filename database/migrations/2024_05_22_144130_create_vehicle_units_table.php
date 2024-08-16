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
        Schema::create('vehicle_units', function (Blueprint $table) {
            $table->id();
            $table->string('alias')->unique();
            $table->string('vin_sn')->unique();
            $table->foreignId('vehicle_brand_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('vehicle_type_id')->nullable()->constrained()->onDelete('set null');
            $table->string('vehicle_model');
            $table->integer('year')->min(1900)->max(date('Y'));
            $table->string('reg_no')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_units');
    }
};
