<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paciente extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'paciente';

    protected $fillable = [
        'nombres','apellidos','tipo_documento_id','numero_documento',
        'fecha_nacimiento','genero_id','telefono','direccion',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    public function genero()
    {
        return $this->belongsTo(Genero::class, 'genero_id');
    }

    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'tipo_documento_id');
    }

    public function muestras()
    {
        return $this->hasMany(MuestraBiologica::class, 'paciente_id');
    }
}
