<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genero;

class GeneroSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['abreviacion' => 'M',  'nombre' => 'Masculino'],
            ['abreviacion' => 'F',  'nombre' => 'Femenino'],
            ['abreviacion' => 'NB', 'nombre' => 'No Binario'],
            ['abreviacion' => 'O',  'nombre' => 'Otro'],
            ['abreviacion' => 'PND','nombre' => 'Prefiere no decir'],
        ];

        foreach ($items as $i) {
            Genero::updateOrCreate(
                ['abreviacion' => $i['abreviacion']], // único
                ['nombre' => $i['nombre']]
            );
        }
    }
}
