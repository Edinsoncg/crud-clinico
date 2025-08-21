<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEstadoMuestraRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $tabla = 'estado_muestra';

        // El parámetro puede venir como modelo o como ID, según tu apiResource/routing
        $param = $this->route('estado_muestra');
        $id = is_object($param) ? $param->id : $param;

        return [
            'nombre' => [
                'sometimes',
                'string',
                'max:60',
                'regex:/^[\pL\s\-]+$/u',
                Rule::unique($tabla, 'nombre')
                    ->where(fn($q) => $q->whereNull('deleted_at'))
                    ->ignore($id),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'required'   => 'El campo :attribute es obligatorio.',
            'string'     => 'El campo :attribute debe ser un texto.',
            'max.string' => 'El campo :attribute no debe superar :max caracteres.',
            'regex'      => 'El campo :attribute solo permite letras, espacios y guiones.',
            'unique'     => 'El :attribute ya existe.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nombre' => 'nombre del estado',
        ];
    }
}
