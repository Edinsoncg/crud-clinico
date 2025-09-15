<?php

namespace App\Repositories\Contracts;

use App\Models\Paciente;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PacienteRepositoryInterface
{
    public function listar(int $porPagina = 15): LengthAwarePaginator;
    public function obtenerPorId(int $id): ?Paciente;
    public function crear(array $data): Paciente;
    public function actualizar(Paciente $paciente, array $data): Paciente;
    public function eliminar(Paciente $paciente): bool;

    public function listarEliminadas(int $porPagina = 15): LengthAwarePaginator;
    public function obtenerEliminadaPorId(int $id): ?Paciente;
    public function restaurar(Paciente $paciente): Paciente;
    public function eliminarDefinitivo(Paciente $paciente): bool;
}
