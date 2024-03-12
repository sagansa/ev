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
        Schema::create('charger_locations', function (Blueprint $table) {
            $table
                ->uuid('id')
                ->primary()
                ->unique();
            $table->string('image')->nullable();
            $table->string('name', 100);
            $table->uuid('provider_id');
            $table
                ->enum('location_on', ['closed', 'dealer', 'private', 'public'])
                ->default('public');
            $table
                ->enum('status', ['verified', 'not verified'])
                ->default('not verified');
            $table->text('description')->nullable();
            $table->string('maps')->nullable();
            $table->enum('system', [
                'free',
                'hour_base',
                'kwh_base',
                'parking_base',
            ]);
            $table->enum('parking', ['yes', 'no']);
            $table->string('coordinate', 100)->nullable();
            $table->unsignedBigInteger('province_id');
            $table->unsignedBigInteger('city_id');
            $table->uuid('user_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charger_locations');
    }
};
