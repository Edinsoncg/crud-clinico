<?php

namespace App\UseCases\Modules\Pacientes;

use App\Models\Paciente;
use App\Repositories\Contracts\PacienteRepositoryInterface;

use App\UseCases\Contracts\Pacientes\EliminarDefinitivoInterface;

class EliminarDefinitivoPaciente implements EliminarDefinitivoInterface
{
    public function __construct(private PacienteRepositoryInterface $repo) {}

    public function handle(Paciente $paciente): bool
    {
        return $this->repo->eliminarDefinitivo($paciente);
    }
}
