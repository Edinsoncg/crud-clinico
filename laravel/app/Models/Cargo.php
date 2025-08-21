<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cargo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cargo';

    protected $fillable = ['nombre', 'abreviatura'];

    public function personal()
    {
        return $this->hasMany(PersonalSalud::class, 'cargo_id');
    }
}
