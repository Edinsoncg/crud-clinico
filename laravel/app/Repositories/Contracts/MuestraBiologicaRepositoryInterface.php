<?php

namespace App\Repositories\Contracts;

use App\Models\MuestraBiologica;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface MuestraBiologicaRepositoryInterface
{
    public function listar(int $porPagina = 15): LengthAwarePaginator;
    public function obtenerPorId(int $id): ?MuestraBiologica;
    public function crear(array $data): MuestraBiologica;
    public function actualizar(MuestraBiologica $muestra, array $data): MuestraBiologica;
    public function eliminar(MuestraBiologica $muestra): void;
}
