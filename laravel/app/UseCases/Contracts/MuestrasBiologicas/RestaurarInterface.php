<?php

namespace App\UseCases\Contracts\MuestrasBiologicas;

use App\Models\MuestraBiologica;

interface RestaurarInterface
{
    public function handle(MuestraBiologica $muestra): MuestraBiologica;
}
