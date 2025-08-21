<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EstadoMuestra;

class EstadoMuestraSeeder extends Seeder
{
    public function run(): void
    {
        $estados = ['Pendiente', 'En análisis', 'Procesada', 'Rechazada', 'Archivada'];

        foreach ($estados as $nombre) {
            EstadoMuestra::updateOrCreate(
                ['nombre' => $nombre],  // clave única
                []                      // preserva created_at; refresca updated_at
            );
        }
    }
}
