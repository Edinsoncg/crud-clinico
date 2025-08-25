<?php

namespace App\UseCases\Contracts\MuestrasBiologicas;

use App\Models\MuestraBiologica;

interface EliminarDefinitivoInterface
{
    public function handle(MuestraBiologica $muestra): bool;
}
