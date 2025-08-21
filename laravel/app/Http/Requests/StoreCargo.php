<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCargoRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $tabla = 'cargo';

        return [
            'nombre' => [
                'required','string','max:80','regex:/^[\pL\s\-]+$/u',
                Rule::unique($tabla, 'nombre')->where(fn($q) => $q->whereNull('deleted_at')),
            ],
            'descripcion' => ['nullable','string','max:255'],
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
            'nombre'      => 'nombre del cargo',
            'descripcion' => 'descripción',
        ];
    }
}
