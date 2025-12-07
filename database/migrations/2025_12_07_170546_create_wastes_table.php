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
        Schema::create('wastes', function (Blueprint $table) {
            $table->id();
            //Relcion con unidad productiva
            $table->foreignId('productive_unit_id')
                ->constrained('productive_units')
                ->cascadeOnDelete();

            //Relacion con el responsable del registro
            $table->foreignId('user_id')
                ->constrained('users');

            //campos de la tabla
            $table->dateTime('entry_date');
            $table->enum('waste_type', [
                'Residuo Organico',
                'Residuo Ordinarios',
                'Residuo Reciclables',
            ]);
            $table->bigInteger('amount');
            $table->text('observations')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wastes');
    }
};
