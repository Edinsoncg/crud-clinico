<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

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

    protected function horaRecoleccion(): Attribute
    {
        return Attribute::make(
            // Al LEER desde BD -> mostrar en el form como HH:mm
            get: fn ($value) =>
                $value ? Carbon::createFromFormat('H:i:s', $value)->format('H:i') : null,

            // Al ESCRIBIR desde el form -> guardar como HH:mm:ss
            set: fn ($value) =>
                $value ? Carbon::createFromFormat('H:i', $value)->format('H:i:s') : null,
        );
    }
}

