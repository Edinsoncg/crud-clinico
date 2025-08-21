<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCargoRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $tabla = 'cargo';
        $param = $this->route('cargo'); // ajusta si tu parámetro se llama distinto
        $id = is_object($param) ? $param->id : $param;

        return [
            'nombre' => [
                'sometimes','string','max:80','regex:/^[\pL\s\-]+$/u',
                Rule::unique($tabla, 'nombre')
                    ->where(fn($q) => $q->whereNull('deleted_at'))
                    ->ignore($id),
            ],
            'descripcion' => ['nullable','string','max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'string'     => 'El campo :attribute debe ser un texto.',
            'max.string' => 'El campo :attribute no debe superar :max caracteres.',
            'regex'      => 'El campo :attribute solo permite letras, espacios y guiones.',
            'unique'     => 'El :attribute ya existe.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nombre'      => 'nombre del cargo',
            'descripcion' => 'descripción',
        ];
    }
}
