<?php

namespace App\UseCases\Contracts\Pacientes;

use App\Models\Paciente;

interface CrearInterface
{
    public function handle(array $data): Paciente;
}
