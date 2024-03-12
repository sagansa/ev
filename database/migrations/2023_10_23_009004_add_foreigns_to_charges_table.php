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
        Schema::table('charges', function (Blueprint $table) {
            $table
                ->foreign('vehicle_id')
                ->references('id')
                ->on('vehicles')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('charger_location_id')
                ->references('id')
                ->on('charger_locations')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('charger_id')
                ->references('id')
                ->on('chargers')
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
        Schema::table('charges', function (Blueprint $table) {
            $table->dropForeign(['vehicle_id']);
            $table->dropForeign(['charger_location_id']);
            $table->dropForeign(['charger_id']);
            $table->dropForeign(['user_id']);
        });
    }
};
