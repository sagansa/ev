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
        Schema::table('chargers', function (Blueprint $table) {
            $table
                ->foreign('charger_location_id')
                ->references('id')
                ->on('charger_locations')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('electric_current_id')
                ->references('id')
                ->on('electric_currents')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('charger_type_id')
                ->references('id')
                ->on('charger_types')
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
        Schema::table('chargers', function (Blueprint $table) {
            $table->dropForeign(['charger_location_id']);
            $table->dropForeign(['electric_current_id']);
            $table->dropForeign(['charger_type_id']);
            $table->dropForeign(['user_id']);
        });
    }
};
