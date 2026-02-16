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
        Schema::dropIfExists('hazardou_waste_outlets');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('hazardou_waste_outlets', function (Blueprint $table) {
            $table->id();
            $table->date('outlet_date');
            $table->bigInteger('amount');
            $table->timestamps();
        });
    }
};
