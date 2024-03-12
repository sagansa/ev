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
        Schema::table('electric_current_sub_merk_vehicle', function (
            Blueprint $table
        ) {
            $table
                ->foreign('electric_current_id')
                ->references('id')
                ->on('electric_currents')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('sub_merk_vehicle_id')
                ->references('id')
                ->on('sub_merk_vehicles')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('electric_current_sub_merk_vehicle', function (
            Blueprint $table
        ) {
            $table->dropForeign(['electric_current_id']);
            $table->dropForeign(['sub_merk_vehicle_id']);
        });
    }
};
