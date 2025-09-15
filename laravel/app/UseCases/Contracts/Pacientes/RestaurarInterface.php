<?php

namespace App\UseCases\Contracts\Pacientes;

use App\Models\Paciente;

interface RestaurarInterface
{
    public function handle(Paciente $paciente): Paciente;
}
