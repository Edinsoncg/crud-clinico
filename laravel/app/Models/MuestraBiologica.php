<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MuestraBiologica extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'muestra_biologica';

    protected $fillable = [
        'codigo_muestra','paciente_id','personal_salud_id',
        'tipo_muestra_id','estado_muestra_id',
        'fecha_recoleccion','hora_recoleccion','lugar_recoleccion',
        'recolectado_por','observaciones',
    ];

    protected $casts = [
        'fecha_recoleccion' => 'date',
        // 'hora_recoleccion' no tiene cast nativo de "time"; lo mantenemos como string
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    public function personalSalud()
    {
        return $this->belongsTo(PersonalSalud::class, 'personal_salud_id');
    }

    public function tipo()
    {
        return $this->belongsTo(TipoMuestra::class, 'tipo_muestra_id');
    }

    public function estado()
    {
        return $this->belongsTo(EstadoMuestra::class, 'estado_muestra_id');
    }
}
