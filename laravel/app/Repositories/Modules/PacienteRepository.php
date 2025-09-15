<?php

namespace App\Repositories\Modules;

use App\Models\Paciente;
use App\Repositories\Contracts\PacienteRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PacienteRepository implements PacienteRepositoryInterface
{
    public function listar(int $porPagina = 15): LengthAwarePaginator
    {
        return Paciente::with(['tipoDocumento','genero'])
            ->latest('id')
            ->paginate($porPagina);
    }

    public function obtenerPorId(int $id): ?Paciente
    {
        return Paciente::with(['tipoDocumento','genero'])->find($id);
    }

    public function crear(array $data): Paciente
    {
        return Paciente::create($data);
    }

    public function actualizar(Paciente $paciente, array $data): Paciente
    {
        $paciente->update($data);
        return $paciente;
    }

    public function eliminar(Paciente $paciente): bool
    {
        $paciente->delete(); // soft delete
        return $paciente->trashed();
    }



    public function listarEliminadas(int $porPagina = 15): LengthAwarePaginator
    {
        return Paciente::onlyTrashed()
            ->with(['tipoDocumento','genero'])
            ->latest('deleted_at')
            ->paginate($porPagina);
    }

    public function obtenerEliminadaPorId(int $id): ?Paciente
    {
        return Paciente::onlyTrashed()->find($id);
    }

    public function restaurar(Paciente $paciente): Paciente
    {
        $paciente->restore();
        return $paciente->fresh();
    }

    public function eliminarDefinitivo(Paciente $paciente): bool
    {
        return (bool) $paciente->forceDelete();
    }
}
