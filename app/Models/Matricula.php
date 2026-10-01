<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    protected $table = 'asis_matriculas';

    protected $fillable = [
        'estudiante_id', 'seccion_id', 'periodo_id', 'fecha_matricula', 'estado',
    ];

    protected $casts = ['fecha_matricula' => 'date'];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }

    public function seccion()
    {
        return $this->belongsTo(Seccion::class, 'seccion_id');
    }

    public function periodo()
    {
        return $this->belongsTo(Periodo::class, 'periodo_id');
    }
}
