<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoDocumento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tipo_documento';

    protected $fillable = ['nombre','abreviatura','longitud_min','longitud_max','activo'];

    protected $casts = [
        'activo' => 'boolean',
        'longitud_min' => 'integer',
        'longitud_max' => 'integer',
    ];

    public function pacientes()
    {
        return $this->hasMany(Paciente::class, 'tipo_documento_id');
    }

    public function personalSalud()
    {
        return $this->hasMany(PersonalSalud::class, 'tipo_documento_id');
    }
}
