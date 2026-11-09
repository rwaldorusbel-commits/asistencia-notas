<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    protected $table = 'asis_notas';

    protected $casts = [
        'valor' => 'decimal:2',
        'peso'  => 'decimal:2',
        'fecha' => 'date',
    ];

    protected $fillable = [
        'matricula_id',
        'asignacion_id',
        'descripcion',
        'valor',
        'peso',
        'fecha',
        'observacion',
    ];

    public function matricula()
    {
        return $this->belongsTo(Matricula::class, 'matricula_id');
    }

    public function asignacion()
    {
        return $this->belongsTo(Asignacion::class, 'asignacion_id');
    }
}
