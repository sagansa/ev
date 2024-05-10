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
        Schema::table('detail_trips', function (Blueprint $table) {
            $table
                ->foreign('trip_id')
                ->references('id')
                ->on('trips')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('charger_location_id')
                ->references('id')
                ->on('charger_locations')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_trips', function (Blueprint $table) {
            $table->dropForeign(['trip_id']);
            $table->dropForeign(['charger_location_id']);
        });
    }
};
