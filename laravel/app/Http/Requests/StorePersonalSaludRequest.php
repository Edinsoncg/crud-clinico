<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePersonalSaludRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $tabla = 'personal_salud';
        $tablaDoc = 'tipo_documento';
        $tablaCargo = 'cargo';

        $uniqueDocumento = Rule::unique($tabla, 'numero_documento')
            ->where(fn($q) => $q->where('tipo_documento_id', $this->input('tipo_documento_id'))
                                ->whereNull('deleted_at'));

        return [
            'nombres'           => ['required','string','max:100','regex:/^[\pL\s\-]+$/u'],
            'apellidos'         => ['required','string','max:120','regex:/^[\pL\s\-]+$/u'],
            'cargo_id'          => ['required',"exists:{$tablaCargo},id"],
            'tipo_documento_id' => ['required',"exists:{$tablaDoc},id"],
            'numero_documento'  => ['required','string','max:20',$uniqueDocumento],
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
        ];
    }

    public function attributes(): array
    {
        return [
            'nombres'           => 'nombres',
            'apellidos'         => 'apellidos',
            'cargo_id'          => 'cargo',
            'tipo_documento_id' => 'tipo de documento',
            'numero_documento'  => 'número de documento',
            'telefono'          => 'teléfono',
            'direccion'         => 'dirección',
        ];
    }
}
