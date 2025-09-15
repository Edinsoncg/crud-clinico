<?php

namespace App\UseCases\Modules\Pacientes;

use App\Models\Paciente;
use App\Repositories\Contracts\PacienteRepositoryInterface;
use App\UseCases\Contracts\Pacientes\ActualizarInterface;

class ActualizarPaciente implements ActualizarInterface
{
    public function __construct(private PacienteRepositoryInterface $repo) {}

    public function handle(Paciente $paciente, array $data): Paciente
    {
        return $this->repo->actualizar($paciente, $data);
    }
}

