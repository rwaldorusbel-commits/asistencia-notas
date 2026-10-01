<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table = 'asis_cursos';

    protected $fillable = ['codigo', 'nombre', 'descripcion', 'activo'];

    protected $casts = ['activo' => 'boolean'];
}
