<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Agrega la columna 'waste_type' a la tabla 'productive_units'.
     * Esta columna indica el tipo de residuo que puede manejar la unidad productiva:
     * - 'convencional': Solo residuos convencionales
     * - 'respel': Solo residuos peligrosos (Respel)
     * - 'ambos': Ambos tipos de residuos
     * 
     * La columna es obligatoria (NOT NULL) con valor por defecto 'convencional'
     * para asegurar que los registros existentes tengan un valor válido.
     */
    public function up(): void
    {
        Schema::table('productive_units', function (Blueprint $table) {
            // Agregar columna enum con valores permitidos
            // NOT NULL con valor por defecto para no afectar registros existentes
            $table->enum('waste_type', ['Residuos Solidos', 'Residuos Peligrosos', 'RESOL/RESPEL'])
                ->default('RESOL/RESPEL')
                ->nullable()
                ->after('description')
                ->comment('Tipo de residuo que puede manejar la unidad productiva');
        });
    }

    /**
     * Reverse the migrations.
     * 
     * Elimina la columna 'waste_type' de la tabla 'productive_units'.
     * Esta operación es reversible y no afecta otros campos de la tabla.
     */
    public function down(): void
    {
        Schema::table('productive_units', function (Blueprint $table) {
            // Eliminar la columna de forma segura
            $table->dropColumn('waste_type');
        });
    }
};
