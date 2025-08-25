<?php

namespace App\UseCases\Modules\MuestrasBiologicas;

use App\Models\MuestraBiologica;
use App\Repositories\Contracts\MuestraBiologicaRepositoryInterface;

use App\UseCases\Contracts\MuestrasBiologicas\EliminarDefinitivoInterface;

class EliminarDefinitivoMuestraBiologica implements EliminarDefinitivoInterface
{
    public function __construct(private MuestraBiologicaRepositoryInterface $repo) {}

    public function handle(MuestraBiologica $muestra): bool
    {
        return $this->repo->eliminarDefinitivo($muestra);
    }
}
