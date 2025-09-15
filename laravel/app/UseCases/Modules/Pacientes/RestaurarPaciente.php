<?php

namespace App\UseCases\Modules\Pacientes;

use App\Models\Paciente;
use App\Repositories\Contracts\PacienteRepositoryInterface;
use App\UseCases\Contracts\Pacientes\RestaurarInterface;

class RestaurarPaciente implements RestaurarInterface
{
    public function __construct(private PacienteRepositoryInterface $repo) {}

    public function handle(Paciente $paciente): Paciente
    {
        return $this->repo->restaurar($paciente);
    }
}
