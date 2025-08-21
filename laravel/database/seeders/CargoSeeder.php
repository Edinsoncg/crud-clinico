<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cargo;

class CargoSeeder extends Seeder
{
    public function run(): void
    {
        $cargos = [
            ['nombre' => 'Médico',                'abreviatura' => 'MED'],
            ['nombre' => 'Técnico de laboratorio','abreviatura' => 'TEC'],
            ['nombre' => 'Enfermera',             'abreviatura' => 'ENF'],
            ['nombre' => 'Bacteriólogo',          'abreviatura' => 'BAC'],
            ['nombre' => 'Auxiliar de enfermería','abreviatura' => 'AUX'],
        ];

        foreach ($cargos as $c) {
            Cargo::updateOrCreate(
                ['nombre' => $c['nombre']],
                ['abreviatura' => $c['abreviatura']]
            );
        }
    }
}
