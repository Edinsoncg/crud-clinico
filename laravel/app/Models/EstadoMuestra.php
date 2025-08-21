<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EstadoMuestra extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'estado_muestra';

    protected $fillable = ['nombre'];

    public function muestras()
    {
        return $this->hasMany(MuestraBiologica::class, 'estado_muestra_id');
    }
}
