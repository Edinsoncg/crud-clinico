<?php

namespace App\UseCases\Modules\Pacientes;

use App\Models\Paciente;
use App\Repositories\Contracts\PacienteRepositoryInterface;
use App\UseCases\Contracts\Pacientes\CrearInterface;

class CrearPaciente implements CrearInterface
{
    public function __construct(private PacienteRepositoryInterface $repo) {}

    public function handle(array $data): Paciente
    {
        return $this->repo->crear($data);
    }
}
