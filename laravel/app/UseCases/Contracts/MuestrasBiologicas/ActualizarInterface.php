<?php

namespace App\UseCases\Contracts\MuestrasBiologicas;

use App\Models\MuestraBiologica;

interface ActualizarInterface
{
    public function handle(MuestraBiologica $muestra, array $data): MuestraBiologica;
}
