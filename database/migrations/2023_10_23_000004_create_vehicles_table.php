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
        Schema::create('vehicles', function (Blueprint $table) {
            $table
                ->uuid('id')
                ->primary()
                ->unique();
            $table->string('image')->nullable();
            $table->unsignedBigInteger('type_vehicle_id');
            $table->unsignedBigInteger('merk_vehicle_id');
            $table->unsignedBigInteger('sub_merk_vehicle_id');
            $table->string('license_plate', 10);
            $table->date('ownership');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->uuid('user_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
