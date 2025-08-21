<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoMuestra;

class TipoMuestraSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = ['Sangre', 'Orina', 'Saliva', 'Biopsia', 'Heces'];

        foreach ($tipos as $nombre) {
            TipoMuestra::updateOrCreate(
                ['nombre' => $nombre], // único
                []
            );
        }
    }
}
