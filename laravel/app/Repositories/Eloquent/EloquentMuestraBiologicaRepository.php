<?php

namespace App\Repositories\Eloquent;

use App\Models\MuestraBiologica;
use App\Repositories\Contracts\MuestraBiologicaRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentMuestraBiologicaRepository implements MuestraBiologicaRepositoryInterface
{
    public function listar(int $porPagina = 15): LengthAwarePaginator
    {
        return MuestraBiologica::with(['paciente','personalSalud','tipo','estado'])
            ->latest('id')
            ->paginate($porPagina);
    }

    public function obtenerPorId(int $id): ?MuestraBiologica
    {
        return MuestraBiologica::with(['paciente','personalSalud','tipo','estado'])->find($id);
    }

    public function crear(array $data): MuestraBiologica
    {
        return MuestraBiologica::create($data);
    }

    public function actualizar(MuestraBiologica $muestra, array $data): MuestraBiologica
    {
        $muestra->update($data);
        return $muestra;
    }

    public function eliminar(MuestraBiologica $muestra): void
    {
        $muestra->delete(); // soft delete
    }
}
