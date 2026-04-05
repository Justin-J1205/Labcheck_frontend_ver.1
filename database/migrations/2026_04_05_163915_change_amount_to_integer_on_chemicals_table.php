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
        Schema::table('chemicals', function (Blueprint $table) {
            // Change the 'amount' column from string to integer
            // Note: You may need 'composer require doctrine/dbal' for older Laravel versions
            $table->integer('amount')->change();

            // Add a 'unit' column so we still know if it's ml, g, or pcs
            $table->string('unit')->default('ml')->after('amount');
        });
    }

    public function down(): void
    {
        Schema::table('chemicals', function (Blueprint $table) {
            $table->string('amount')->change();
            $table->dropColumn('unit');
        });
    }
};
