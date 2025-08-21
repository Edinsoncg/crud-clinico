<?php

namespace App\UseCases\Contracts\MuestrasBiologicas;

use App\Models\MuestraBiologica;

interface ActualizarInterface
{
    public function manejar(MuestraBiologica $muestra, array $data): MuestraBiologica;
}
