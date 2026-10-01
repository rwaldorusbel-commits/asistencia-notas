<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $table = 'asis_asistencias';
    protected $casts = ['fecha' => 'date'];
    protected $fillable = [
        'asignacion_id',
        'matricula_id',
        'fecha',
        'estado',
        'observacion',
    ];

    public function matricula()
    {
        return $this->belongsTo(Matricula::class);
    }

    public function asignacion()
    {
        return $this->belongsTo(Asignacion::class);
    }

    public function justificacion()
    {
        return $this->hasOne(Justificacion::class);
    }
}
