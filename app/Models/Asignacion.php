<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asignacion extends Model
{
    protected $table = 'asis_asignaciones';

    protected $fillable = ['docente_id', 'curso_id', 'seccion_id', 'activo'];

    protected $casts = ['activo' => 'boolean'];

    public function docente() { return $this->belongsTo(User::class, 'docente_id'); }
    public function curso()   { return $this->belongsTo(Curso::class); }
    public function seccion() { return $this->belongsTo(Seccion::class); }
}
