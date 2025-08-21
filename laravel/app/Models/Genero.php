<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Genero extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'genero';

    protected $fillable = ['nombre', 'abreviacion'];

    public function pacientes()
    {
        return $this->hasMany(Paciente::class, 'genero_id');
    }
}
