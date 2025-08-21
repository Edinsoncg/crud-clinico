<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoDocumento;

class TipoDocumentoSeeder extends Seeder
{
    public function run(): void
    {
        $docs = [
            ['abreviatura'=>'CC',  'nombre'=>'Cédula de ciudadanía',  'min'=>6, 'max'=>10],
            ['abreviatura'=>'TI',  'nombre'=>'Tarjeta de identidad',  'min'=>6, 'max'=>10],
            ['abreviatura'=>'CE',  'nombre'=>'Cédula de extranjería', 'min'=>6, 'max'=>15],
            ['abreviatura'=>'PAS', 'nombre'=>'Pasaporte',             'min'=>6, 'max'=>15],
            ['abreviatura'=>'NIT', 'nombre'=>'NIT',                   'min'=>9, 'max'=>10],
        ];

        foreach ($docs as $d) {
            TipoDocumento::updateOrCreate(
                ['abreviatura' => $d['abreviatura']], // único
                [
                    'nombre'        => $d['nombre'],
                    'longitud_min'  => $d['min'],
                    'longitud_max'  => $d['max'],
                    'activo'        => true,
                ]
            );
        }
    }
}
