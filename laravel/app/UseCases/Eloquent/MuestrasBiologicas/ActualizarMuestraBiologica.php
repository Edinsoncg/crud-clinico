<?php

namespace App\UseCases\MuestrasBiologicas;

use App\Models\MuestraBiologica;
use App\Repositories\Contracts\MuestraBiologicaRepositoryInterface;
use App\UseCases\Contracts\MuestrasBiologicas\ActualizarInterface;

class ActualizarMuestraBiologica implements ActualizarInterface
{
    public function __construct(private MuestraBiologicaRepositoryInterface $repo) {}

    public function manejar(MuestraBiologica $muestra, array $data): MuestraBiologica
    {
        return $this->repo->actualizar($muestra, $data);
    }
}

