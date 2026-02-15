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
        Schema::table('wastes', function (Blueprint $table) {
            $table->index(['productive_unit_id', 'entry_date'], 'wastes_productive_unit_entry_date_idx');
        });

        Schema::table('hazardou_wastes', function (Blueprint $table) {
            $table->index(['productive_unit_id', 'entry_date'], 'hazardou_wastes_productive_unit_entry_date_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wastes', function (Blueprint $table) {
            $table->dropIndex('wastes_productive_unit_entry_date_idx');
        });

        Schema::table('hazardou_wastes', function (Blueprint $table) {
            $table->dropIndex('hazardou_wastes_productive_unit_entry_date_idx');
        });
    }
};
