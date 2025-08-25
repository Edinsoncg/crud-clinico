<?php

namespace App\UseCases\Modules\MuestrasBiologicas;

use App\Models\MuestraBiologica;
use App\Repositories\Contracts\MuestraBiologicaRepositoryInterface;
use App\UseCases\Contracts\MuestrasBiologicas\RestaurarInterface;

class RestaurarMuestraBiologica implements RestaurarInterface
{
    public function __construct(private MuestraBiologicaRepositoryInterface $repo) {}

    public function handle(MuestraBiologica $muestra): MuestraBiologica
    {
        return $this->repo->restaurar($muestra);
    }
}
