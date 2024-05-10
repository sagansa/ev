<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('electric_current_sub_merk_vehicle', function (
            Blueprint $table
        ) {
            $table->unsignedBigInteger('electric_current_id');
            $table->unsignedBigInteger('sub_merk_vehicle_id');
            $table->string('Max_charge_capacity')->nullable();
            $table->string('charging_percentage', 20)->nullable();
            $table->string('charging_time', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('electric_current_sub_merk_vehicle');
    }
};
