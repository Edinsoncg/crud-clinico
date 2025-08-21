<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoMuestra extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tipo_muestra';

    protected $fillable = ['nombre'];

    public function muestras()
    {
        return $this->hasMany(MuestraBiologica::class, 'tipo_muestra_id');
    }
}
