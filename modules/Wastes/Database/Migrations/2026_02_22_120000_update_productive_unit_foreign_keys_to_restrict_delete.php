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
            $table->dropForeign(['productive_unit_id']);
        });

        Schema::table('wastes', function (Blueprint $table) {
            $table->foreign('productive_unit_id')
                ->references('id')
                ->on('productive_units')
                ->restrictOnDelete();
        });

        Schema::table('hazardou_wastes', function (Blueprint $table) {
            $table->dropForeign(['productive_unit_id']);
        });

        Schema::table('hazardou_wastes', function (Blueprint $table) {
            $table->foreign('productive_unit_id')
                ->references('id')
                ->on('productive_units')
                ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wastes', function (Blueprint $table) {
            $table->dropForeign(['productive_unit_id']);
        });

        Schema::table('wastes', function (Blueprint $table) {
            $table->foreign('productive_unit_id')
                ->references('id')
                ->on('productive_units')
                ->cascadeOnDelete();
        });

        Schema::table('hazardou_wastes', function (Blueprint $table) {
            $table->dropForeign(['productive_unit_id']);
        });

        Schema::table('hazardou_wastes', function (Blueprint $table) {
            $table->foreign('productive_unit_id')
                ->references('id')
                ->on('productive_units')
                ->cascadeOnDelete();
        });
    }
};
