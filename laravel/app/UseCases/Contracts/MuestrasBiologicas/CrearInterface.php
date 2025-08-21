<?php

namespace App\UseCases\Contracts\MuestrasBiologicas;

use App\Models\MuestraBiologica;

interface CrearInterface
{
    public function manejar(array $data): MuestraBiologica;
}
