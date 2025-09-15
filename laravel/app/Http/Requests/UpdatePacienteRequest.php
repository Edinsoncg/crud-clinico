<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePacienteRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $tablaPac = 'paciente';
        $tablaDoc = 'tipo_documento';
        $tablaGen = 'genero';

        // El parámetro de ruta {paciente} puede venir como ID o como modelo
        $pacienteParam = $this->route('paciente');
        $pacienteId = is_object($pacienteParam) ? $pacienteParam->id : $pacienteParam;

        // Si no envían tipo_documento_id en el update, usamos el del registro actual
        $tipoDocumentoId = $this->input('tipo_documento_id')
            ?? (is_object($pacienteParam) ? $pacienteParam->tipo_documento_id : null);

        $uniqueDocumento = Rule::unique($tablaPac, 'numero_documento')
            ->where(fn($q) => $q->where('tipo_documento_id', $tipoDocumentoId)
                                ->whereNull('deleted_at'))
            ->ignore($pacienteId); // ignorar el propio registro

        return [
            'nombres'           => ['sometimes','string','max:100','regex:/^[\pL\s\-]+$/u'],
            'apellidos'         => ['sometimes','string','max:120','regex:/^[\pL\s\-]+$/u'],
            'tipo_documento_id' => ['sometimes',"exists:{$tablaDoc},id"],
            'numero_documento'  => ['sometimes','string','max:20',$uniqueDocumento],
            'fecha_nacimiento'  => ['nullable','date','before:today'],
            'genero_id'         => ['nullable',"exists:{$tablaGen},id"],
            'telefono'          => ['nullable','string','max:20'],
            'direccion'         => ['nullable','string','max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'required'     => 'El campo :attribute es obligatorio.',
            'string'       => 'El campo :attribute debe ser un texto.',
            'max.string'   => 'El campo :attribute no debe superar :max caracteres.',
            'regex'        => 'El campo :attribute solo permite letras, espacios y guiones.',
            'exists'       => 'El :attribute seleccionado no es válido.',
            'unique'       => 'El :attribute ya está en uso.',
            'date'         => 'El campo :attribute debe ser una fecha válida.',
            'before'       => 'El campo :attribute debe ser anterior a hoy.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nombres'           => 'nombres',
            'apellidos'         => 'apellidos',
            'tipo_documento_id' => 'tipo de documento',
            'numero_documento'  => 'número de documento',
            'fecha_nacimiento'  => 'fecha de nacimiento',
            'genero_id'         => 'género',
            'telefono'          => 'teléfono',
            'direccion'         => 'dirección',
        ];
    }
}
