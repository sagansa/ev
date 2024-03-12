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
        Schema::create('state_of_healths', function (Blueprint $table) {
            $table
                ->uuid('id')
                ->primary()
                ->unique();
            $table->string('image')->nullable();
            $table->uuid('vehicle_id');
            $table->integer('km');
            $table->decimal('percentage', 10, 2);
            $table->text('how_to_charge')->nullable();
            $table
                ->enum('status', ['not verified', 'verified'])
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
        Schema::dropIfExists('state_of_healths');
    }
};
