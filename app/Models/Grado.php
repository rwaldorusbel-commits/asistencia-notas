<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grado extends Model
{
    protected $table = 'asis_grados';

    protected $fillable = ['nombre', 'orden', 'activo'];

    protected $casts = [
        'activo' => 'boolean',
    ];
}
