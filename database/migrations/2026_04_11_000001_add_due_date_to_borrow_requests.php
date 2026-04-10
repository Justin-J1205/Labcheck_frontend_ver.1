<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('borrow_requests', function (Blueprint $table) {
            $table->dateTime('due_date')->nullable()->after('quantity');
            $table->boolean('is_overdue')->default(false)->after('returned_at');
        });
    }

    public function down(): void
    {
        Schema::table('borrow_requests', function (Blueprint $table) {
            $table->dropColumn(['due_date', 'is_overdue']);
        });
    }
};
