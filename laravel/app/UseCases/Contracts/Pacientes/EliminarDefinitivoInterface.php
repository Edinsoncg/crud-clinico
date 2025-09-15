<?php

namespace App\UseCases\Contracts\Pacientes;

use App\Models\Paciente;

interface EliminarDefinitivoInterface
{
    public function handle(Paciente $paciente): bool;
}
