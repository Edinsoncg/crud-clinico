<?php

namespace App\UseCases\MuestrasBiologicas;

use App\Models\MuestraBiologica;
use App\Repositories\Contracts\MuestraBiologicaRepositoryInterface;
use App\UseCases\Contracts\MuestrasBiologicas\CrearInterface;

class CrearMuestraBiologica implements CrearInterface
{
    public function __construct(private MuestraBiologicaRepositoryInterface $repo) {}

    public function manejar(array $data): MuestraBiologica
    {
        return $this->repo->crear($data);
    }
}
