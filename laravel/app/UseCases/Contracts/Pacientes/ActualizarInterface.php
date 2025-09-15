<?php

namespace App\UseCases\Contracts\Pacientes;

use App\Models\Paciente;

interface ActualizarInterface
{
    public function handle(Paciente $paciente, array $data): Paciente;
}
