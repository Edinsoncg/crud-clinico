<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PersonalSalud extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'personal_salud';

    protected $fillable = [
        'nombres',
        'apellidos',
        'cargo_id',
        'tipo_documento_id',
        'numero_documento',
        'telefono',
        'direccion',
    ];

    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'cargo_id');
    }

    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'tipo_documento_id');
    }

    public function muestras()
    {
        return $this->hasMany(MuestraBiologica::class, 'personal_salud_id');
    }
}
