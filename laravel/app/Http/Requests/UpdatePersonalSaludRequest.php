<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePersonalSaludRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $tabla = 'personal_salud';
        $tablaDoc = 'tipo_documento';
        $tablaCargo = 'cargo';

        // El parámetro de ruta puede ser modelo o ID. Ajusta el nombre si tu ruta usa otro (p. ej. 'personal-salud').
        $param = $this->route('personal_salud');
        $id = is_object($param) ? $param->id : $param;

        // Si no envían tipo_documento_id en el update, usa el del registro actual
        $tipoDocumentoId = $this->input('tipo_documento_id')
            ?? (is_object($param) ? $param->tipo_documento_id : null);

        $uniqueDocumento = Rule::unique($tabla, 'numero_documento')
            ->where(fn($q) => $q->where('tipo_documento_id', $tipoDocumentoId)
                                ->whereNull('deleted_at'))
            ->ignore($id);

        return [
            'nombres'           => ['sometimes','string','max:100','regex:/^[\pL\s\-]+$/u'],
            'apellidos'         => ['sometimes','string','max:120','regex:/^[\pL\s\-]+$/u'],
            'cargo_id'          => ['sometimes',"exists:{$tablaCargo},id"],
            'tipo_documento_id' => ['sometimes',"exists:{$tablaDoc},id"],
            'numero_documento'  => ['sometimes','string','max:20',$uniqueDocumento],
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
