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
        Schema::create('sub_merk_vehicles', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->unsignedBigInteger('type_vehicle_id');
            $table->unsignedBigInteger('merk_vehicle_id');
            $table->string('sub_merk', 30)->unique();
            $table->unsignedBigInteger('charger_type_id');
            $table->decimal('battery_capacity', 10, 1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_merk_vehicles');
    }
};
