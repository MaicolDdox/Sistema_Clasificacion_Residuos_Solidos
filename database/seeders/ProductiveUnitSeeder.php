<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Areas\Models\Area;
use Modules\ProductiveUnits\Models\ProductiveUnit;

class ProductiveUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Area Agricola' => [
                'Unidad aguacate',
                'Unidad cacao',
                'Unidad citricos',
                'Unidad guanabana',
                'Unidad guayaba',
                'Unidad hurrtaila',
                'Unidad invernadero',
                'Unidad jardin clonar',
                'Unidad piña',
                'Unidad policultivo',
                'Unidad riego',
                'Unidad vivero frutales',
            ],

            'Area Ambiental' => [
                'Unidad acantarillado y tratamiento',
                'Unidad ambiental acuicola',
                'Unidad ambiental agricola',
                'Unidad ambiental agroindustria',
                'Unidad ambiental pecuario',
                'Unidad compostaje',
                'Unidad costos ambientales',
                'Unidad lombricultivo',
                'Unidad ecoturismo',
                'Unidad educación ambiental',
                'Unidad monitoreo aire y ruido',
                'Unidad platat de tratamiento residuos solidos',
                'Unidad ptap acueducto',
                'Unidad de guada',
                'Unidad zona agroecológica',
                'Unidad zonas verdes',
                'Unidad vivero forestal y ornamental',
            ],

            'Area infraestructura' => [
                'Unidad ovino',
                'Unidad agroindustria',
                'Unidad pocino',
                'Unidad bodega de agoinsumos',
                'Unidad praderas',
                'Unidad cafeteria',
                'Unidad estaacion de cafe',
                'Unidad hangar',
                'Unidad laboratorio biotecnologia',
                'Unidad laboratorio fisicoquimico',
                'Unidad laboratorio microbiologia',
            ],

            'Area Pecuaria' => [
                'Unidad acuicola',
                'Unidad apicola',
                'Unidad avicola',
                'Unidad bovino',
                'Unidad ordeño',
                'Unidad ovino',
                'Unidad pocino',
                'Unidad praderas',
            ],
        ];

        foreach ($data as $areaName => $units) {
            // Nos aseguramos de que el área exista
            $area = Area::firstOrCreate(
                ['name' => $areaName],
                ['description' => "Area de prueba"]
            );

            foreach ($units as $unitName) {
                ProductiveUnit::firstOrCreate(
                    [
                        'area_id' => $area->id,
                        'name'    => $unitName,
                    ],
                    [
                        'description' => "Unidad productiva de prueba",
                    ]
                );
            }
        }
    }
}
