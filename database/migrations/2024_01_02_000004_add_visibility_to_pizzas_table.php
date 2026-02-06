<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pizzas', function (Blueprint $table) {
            $table->boolean('is_visible')->default(true)->after('is_available');
            $table->integer('sort_order')->default(0)->after('is_visible');
        });
    }

    public function down(): void
    {
        Schema::table('pizzas', function (Blueprint $table) {
            $table->dropColumn(['is_visible', 'sort_order']);
        });
    }
};
