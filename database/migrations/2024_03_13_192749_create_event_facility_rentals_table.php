<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('event_facility_rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('halls_id')->constrained('halls')->cascadeOnDelete();
            $table->foreignId('events_id')->constrained('events')->cascadeOnDelete();
            $table->decimal('event_rental_rate',8,2)->nullable();
            $table->foreignId('facilities_id')->nullable()->constrained('facilities')->cascadeOnDelete();
            $table->integer('quantity')->nullable();
            $table->decimal('facility_rental_rate',8,2)->nullable();
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_facility_rentals');
    }
};
