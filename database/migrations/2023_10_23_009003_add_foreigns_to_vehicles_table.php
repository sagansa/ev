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
        Schema::table('vehicles', function (Blueprint $table) {
            $table
                ->foreign('type_vehicle_id')
                ->references('id')
                ->on('type_vehicles')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('merk_vehicle_id')
                ->references('id')
                ->on('merk_vehicles')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('sub_merk_vehicle_id')
                ->references('id')
                ->on('sub_merk_vehicles')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropForeign(['type_vehicle_id']);
            $table->dropForeign(['merk_vehicle_id']);
            $table->dropForeign(['sub_merk_vehicle_id']);
            $table->dropForeign(['user_id']);
        });
    }
};
