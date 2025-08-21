<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTipoMuestraRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $tabla = 'tipo_muestra';
        $param = $this->route('tipo_muestra'); // ajusta si tu parámetro se llama distinto
        $id = is_object($param) ? $param->id : $param;

        return [
            'nombre' => [
                'sometimes','string','max:100','regex:/^[\pL\s\-]+$/u',
                Rule::unique($tabla, 'nombre')
                    ->where(fn($q) => $q->whereNull('deleted_at'))
                    ->ignore($id),
            ],
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
        return ['nombre' => 'nombre del tipo de muestra'];
    }
}
