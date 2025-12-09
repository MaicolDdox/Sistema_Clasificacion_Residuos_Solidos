<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Modules\ProductiveUnits\Models\ProductiveUnit;
use Modules\Wastes\Models\HazardouWaste;
use Modules\Wastes\Models\Waste;
use App\Models\User;

class WasteSampleSeeder extends Seeder
{
    /**
     * Seed 30 RESOL and 30 RESPEL records per productive unit with weekly flow.
     */
    public function run(): void
    {
        $userId = User::query()->first()?->id;
        if (! $userId) {
            return;
        }

        $resolTypes = ['Residuo Organico', 'Residuo Ordinarios', 'Residuo Reciclables'];
        $respelTypes = ['Residuo Quimico', 'Residuo Biologico', 'Residuo Organico Peligroso'];

        ProductiveUnit::all()->each(function (ProductiveUnit $unit) use ($userId, $resolTypes, $respelTypes) {
            // Punto de partida: hace 29 semanas, lunes
            $startWeek = Carbon::now()->startOfWeek(Carbon::MONDAY)->subWeeks(29);

            for ($i = 0; $i < 30; $i++) {
                $entryDate = $startWeek->copy()->addWeeks($i)->addDays(random_int(0, 2)); // variación 0-2 días dentro de la semana

                // RESOL
                Waste::create([
                    'productive_unit_id' => $unit->id,
                    'user_id' => $userId,
                    'entry_date' => $entryDate,
                    'waste_type' => $resolTypes[array_rand($resolTypes)],
                    'amount' => random_int(5, 50),
                    'observations' => 'Registro RESOL simulado semana '.$entryDate->format('W'),
                ]);

                // RESPEL
                HazardouWaste::create([
                    'productive_unit_id' => $unit->id,
                    'user_id' => $userId,
                    'entry_date' => $entryDate->copy()->addDays(random_int(0, 1)), // leve desplazamiento
                    'waste_type' => $respelTypes[array_rand($respelTypes)],
                    'amount' => random_int(3, 35),
                    'observations' => 'Registro RESPEL simulado semana '.$entryDate->format('W'),
                ]);
            }
        });
    }
}
