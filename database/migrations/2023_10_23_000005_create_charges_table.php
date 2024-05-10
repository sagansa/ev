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
        Schema::create('charges', function (Blueprint $table) {
            $table
                ->uuid('id')
                ->primary()
                ->unique();
            $table->uuid('vehicle_id');
            $table->date('date');
            $table->uuid('charger_location_id');
            $table->uuid('charger_id');
            $table->integer('km_now');
            $table->integer('km_before');
            $table->integer('battery_start_charging');
            $table->integer('battery_finish_charging')->nullable();
            $table->integer('battery_finish_before');
            $table
                ->integer('parking')
                ->default(0)
                ->nullable();
            $table->decimal('kWh', 8, 3)->nullable();
            $table
                ->integer('PPJ')
                ->default(0)
                ->nullable();
            $table
                ->integer('PPN')
                ->default(0)
                ->nullable();
            $table
                ->integer('admin_cost')
                ->default(0)
                ->nullable();
            $table->integer('total_cost')->nullable();
            $table->string('image')->nullable();
            $table->uuid('user_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charges');
    }
};
