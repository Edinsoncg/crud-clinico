<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MuestraBiologica;

class MuestraBiologicaSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'codigo_muestra' => 'MX001',
                'paciente_id' => 1,
                'personal_salud_id' => 1,
                'tipo_muestra_id' => 1,
                'estado_muestra_id' => 1,
                'fecha_recoleccion' => now()->toDateString(),
                'hora_recoleccion' => '08:30:00',
                'lugar_recoleccion' => 'Laboratorio Central',
                'recolectado_por'   => 'Andrea Rojas',
                'observaciones'     => 'Ayunas',
            ],
            [
                'codigo_muestra' => 'MX002',
                'paciente_id' => 2,
                'personal_salud_id' => 1,
                'tipo_muestra_id' => 2,
                'estado_muestra_id' => 2,
                'fecha_recoleccion' => now()->toDateString(),
                'hora_recoleccion' => '10:15:00',
                'lugar_recoleccion' => 'Puesto de Toma #2',
                'recolectado_por'   => 'Andrea Rojas',
                'observaciones'     => null,
            ],
            [
                'codigo_muestra' => 'MX003',
                'paciente_id' => 3,
                'personal_salud_id' => 2,
                'tipo_muestra_id' => 3,
                'estado_muestra_id' => 3,
                'fecha_recoleccion' => now()->subDay()->toDateString(),
                'hora_recoleccion' => '09:00:00',
                'lugar_recoleccion' => 'Unidad Básica',
                'recolectado_por'   => 'Luis Martínez',
                'observaciones'     => 'Sin incidencias',
            ],
        ];

        foreach ($rows as $r) {
            MuestraBiologica::updateOrCreate(
                ['codigo_muestra' => $r['codigo_muestra']], // único
                [
                    'paciente_id'        => $r['paciente_id'],
                    'personal_salud_id'  => $r['personal_salud_id'],
                    'tipo_muestra_id'    => $r['tipo_muestra_id'],
                    'estado_muestra_id'  => $r['estado_muestra_id'],
                    'fecha_recoleccion'  => $r['fecha_recoleccion'],
                    'hora_recoleccion'   => $r['hora_recoleccion'],
                    'lugar_recoleccion'  => $r['lugar_recoleccion'],
                    'recolectado_por'    => $r['recolectado_por'],
                    'observaciones'      => $r['observaciones'],
                ]
            );
        }
    }
}
