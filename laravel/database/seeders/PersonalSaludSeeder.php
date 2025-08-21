<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PersonalSalud;

class PersonalSaludSeeder extends Seeder
{
    public function run(): void
    {
        // tipo_documento_id: 1=CC, 3=CE
        $rows = [
            [
                'tipo_documento_id' => 1,
                'numero_documento' => '9001001',
                'nombres' => 'Andrea',
                'apellidos' => 'Rojas Mejía',
                'cargo_id' => 2,
                'telefono' => '3101111111',
                'direccion' => 'Av 4 # 12-34',
            ],
            [
                'tipo_documento_id' => 1,
                'numero_documento' => '9001002',
                'nombres' => 'Luis',
                'apellidos' => 'Martínez Gómez',
                'cargo_id' => 1,
                'telefono' => '3102222222',
                'direccion' => 'Mz A Casa 12',
            ],
            [
                'tipo_documento_id' => 3,
                'numero_documento' => '132123456',
                'nombres' => 'Sofía',
                'apellidos' => 'Hernández Vila',
                'cargo_id' => 3,
                'telefono' => null,
                'direccion' => null,
            ],
        ];

        foreach ($rows as $ps) {
            PersonalSalud::updateOrCreate(
                ['tipo_documento_id' => $ps['tipo_documento_id'], 'numero_documento' => $ps['numero_documento']], // único
                [
                    'nombres'   => $ps['nombres'],
                    'apellidos' => $ps['apellidos'],
                    'cargo_id'  => $ps['cargo_id'],
                    'telefono'  => $ps['telefono'],
                    'direccion' => $ps['direccion'],
                ]
            );
        }
    }
}
