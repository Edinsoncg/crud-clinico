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
    public function eliminar(MuestraBiologica $muestra): bool;

    public function listarEliminadas(int $porPagina = 15): LengthAwarePaginator;
    public function obtenerEliminadaPorId(int $id): ?MuestraBiologica;
    public function restaurar(MuestraBiologica $muestra): MuestraBiologica;
    public function eliminarDefinitivo(MuestraBiologica $muestra): bool;
}
