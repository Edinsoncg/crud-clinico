<?php

namespace App\Repositories\Modules;

use App\Models\MuestraBiologica;
use App\Repositories\Contracts\MuestraBiologicaRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class MuestraBiologicaRepository implements MuestraBiologicaRepositoryInterface
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

    public function eliminar(MuestraBiologica $muestra): bool
    {
        $muestra->delete(); // soft delete
        return $muestra->trashed();
    }



    public function listarEliminadas(int $porPagina = 15): LengthAwarePaginator
    {
        return MuestraBiologica::onlyTrashed()
            ->with(['paciente','personalSalud','tipo','estado'])
            ->latest('deleted_at')
            ->paginate($porPagina);
    }

    public function obtenerEliminadaPorId(int $id): ?MuestraBiologica
    {
        return MuestraBiologica::onlyTrashed()->find($id);
    }

    public function restaurar(MuestraBiologica $muestra): MuestraBiologica
    {
        $muestra->restore();
        return $muestra->fresh();
    }

    public function eliminarDefinitivo(MuestraBiologica $muestra): bool
    {
         return (bool) $muestra->forceDelete();
    }
}
