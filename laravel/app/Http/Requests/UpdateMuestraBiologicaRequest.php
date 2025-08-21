<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMuestraBiologicaRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $tabla = 'muestra_biologica';

        // El parámetro puede venir como modelo o como ID (según Route Model Binding)
        $param = $this->route('muestra_biologica'); // cámbialo si tu parámetro se llama distinto
        $id = is_object($param) ? $param->id : $param;

        return [
            'codigo_muestra'     => [
                'sometimes','string','max:50',
                Rule::unique($tabla, 'codigo_muestra')
                    ->where(fn($q) => $q->whereNull('deleted_at'))
                    ->ignore($id),
            ],
            'paciente_id'        => ['sometimes','integer','exists:paciente,id'],
            'personal_salud_id'  => ['sometimes','integer','exists:personal_salud,id'],
            'tipo_muestra_id'    => ['sometimes','integer','exists:tipo_muestra,id'],
            'estado_muestra_id'  => ['sometimes','integer','exists:estado_muestra,id'],
            'fecha_recoleccion'  => ['sometimes','date','before_or_equal:today'],
            'hora_recoleccion'   => ['sometimes','date_format:H:i'],
            'lugar_recoleccion'  => ['sometimes','string','max:150'],
            'recolectado_por'    => ['sometimes','string','max:100'],
            'observaciones'      => ['nullable','string'],
        ];
    }

    public function messages(): array
    {
        return [
            'required'                => 'El campo :attribute es obligatorio.',
            'integer'                 => 'El campo :attribute debe ser un número entero.',
            'string'                  => 'El campo :attribute debe ser un texto.',
            'max.string'              => 'El campo :attribute no debe superar :max caracteres.',
            'unique'                  => 'El :attribute ya existe.',
            'exists'                  => 'El :attribute seleccionado no es válido.',
            'date'                    => 'El campo :attribute debe ser una fecha válida.',
            'before_or_equal'         => 'El campo :attribute debe ser anterior o igual a hoy.',
            'date_format'             => 'El campo :attribute debe tener el formato HH:mm.',
        ];
    }

    public function attributes(): array
    {
        return [
            'codigo_muestra'     => 'código de la muestra',
            'paciente_id'        => 'paciente',
            'personal_salud_id'  => 'personal de salud',
            'tipo_muestra_id'    => 'tipo de muestra',
            'estado_muestra_id'  => 'estado de la muestra',
            'fecha_recoleccion'  => 'fecha de recolección',
            'hora_recoleccion'   => 'hora de recolección',
            'lugar_recoleccion'  => 'lugar de recolección',
            'recolectado_por'    => 'nombre de quien recolectó',
            'observaciones'      => 'observaciones',
        ];
    }
}
