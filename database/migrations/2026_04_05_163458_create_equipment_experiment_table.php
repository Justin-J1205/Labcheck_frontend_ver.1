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
        Schema::create('equipment_experiment', function (Blueprint $table) {
            $table->id();
            // This links to the Experiments table
            $table->foreignId('experiment_id')->constrained()->onDelete('cascade');
            // This links to the Equipments table
            $table->foreignId('equipment_id')->constrained()->onDelete('cascade');
            // The "How Many" part wanted!
            $table->integer('quantity_needed')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_experiment');
    }
};
