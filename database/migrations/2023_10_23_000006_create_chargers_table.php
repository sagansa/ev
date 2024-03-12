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
        Schema::create('chargers', function (Blueprint $table) {
            $table
                ->uuid('id')
                ->primary()
                ->unique();
            $table->uuid('charger_location_id');
            $table->unsignedBigInteger('electric_current_id');
            $table->unsignedBigInteger('charger_type_id');
            $table->string('power', 10);
            $table->tinyInteger('unit');
            $table->integer('charge_cost');
            $table->integer('PPJ');
            $table->integer('admin_cost');
            $table->enum('PPN', ['yes', 'no']);
            $table
                ->enum('status', ['verified', 'not verified', 'closed'])
                ->default('not verified');
            $table->uuid('user_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chargers');
    }
};
