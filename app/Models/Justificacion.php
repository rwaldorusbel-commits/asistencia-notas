<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Justificacion extends Model
{
    protected $table = 'asis_justificaciones';

    protected $fillable = ['asistencia_id', 'estado_original', 'motivo', 'registrado_por'];

    public function asistencia() { return $this->belongsTo(Asistencia::class); }
    public function autor()      { return $this->belongsTo(User::class, 'registrado_por'); }
}
