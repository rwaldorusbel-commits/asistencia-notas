<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    protected $table = 'asis_periodos';

    protected $fillable = [
        'nombre', 'anio', 'tipo', 'fecha_inicio', 'fecha_fin', 'activo', 'notas_cerradas',
    ];

    protected $casts = [
        'fecha_inicio'   => 'date',
        'fecha_fin'      => 'date',
        'activo'         => 'boolean',
        'notas_cerradas' => 'boolean',
    ];

}
