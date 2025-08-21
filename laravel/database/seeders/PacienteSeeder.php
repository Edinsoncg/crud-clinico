<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Paciente;

class PacienteSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'tipo_documento_id' => 1,
                'numero_documento' => '1001001',
                'nombres' => 'Carlos Andrés',
                'apellidos' => 'García Pérez',
                'fecha_nacimiento' => '1990-05-12',
                'genero_id' => 1,
                'telefono' => '3001111111',
                'direccion' => 'Cra 10 # 20-30',
            ],
            [
                'tipo_documento_id' => 1,
                'numero_documento' => '1001002',
                'nombres' => 'María Fernanda',
                'apellidos' => 'López Díaz',
                'fecha_nacimiento' => '1995-01-22',
                'genero_id' => 2,
                'telefono' => '3002222222',
                'direccion' => 'Cll 5 # 15-40',
            ],
            [
                'tipo_documento_id' => 2,
                'numero_documento' => '9900777',
                'nombres' => 'Juan Sebastián',
                'apellidos' => 'Ruiz Torres',
                'fecha_nacimiento' => '2007-08-10',
                'genero_id' => 1,
                'telefono' => null,
                'direccion' => null,
            ],
        ];

        foreach ($rows as $p) {
            Paciente::updateOrCreate(
                ['tipo_documento_id' => $p['tipo_documento_id'], 'numero_documento' => $p['numero_documento']], // único
                [
                    'nombres'          => $p['nombres'],
                    'apellidos'        => $p['apellidos'],
                    'fecha_nacimiento' => $p['fecha_nacimiento'],
                    'genero_id'        => $p['genero_id'],
                    'telefono'         => $p['telefono'],
                    'direccion'        => $p['direccion'],
                ]
            );
        }
    }
}
