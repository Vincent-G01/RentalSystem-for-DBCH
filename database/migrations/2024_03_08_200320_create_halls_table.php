<?php

use App\Models\City;
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
        Schema::create('halls', function (Blueprint $table) {
            $table->id();
            $table->string('diagram')->nullable();
            $table->string('name');
            
            $table->foreignId('cities_id')->constrained('cities')->cascadeOnDelete();
            
            $table->integer('capacity');
            $table->boolean('maintainance_status');
            $table->date('maintainance_start_date') ->nullable();
            $table->date('maintainance_end_date')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('halls');
    }
};
