<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Area;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = [
            'Area Agricola',
            'Area Ambiental',
            'Area infraestructura',
            'Area Pecuaria',
        ];

        foreach ($areas as $name) {
            Area::firstOrCreate(
                ['name' => $name],
                ['description' => null]
            );
        }
    }
}
