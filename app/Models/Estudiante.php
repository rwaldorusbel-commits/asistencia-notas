<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $table = 'asis_estudiantes';

    protected $fillable = [
    'codigo', 'dni', 'apoderado_id', 'nombres', 'apellidos', 'fecha_nacimiento', 'activo',
];

    protected $casts = [
        'activo' => 'boolean',
        'fecha_nacimiento' => 'date',
    ];

    public function apoderado()
    {
        return $this->belongsTo(Apoderado::class, 'apoderado_id');
    }
    protected static function booted()
{
    static::creating(function ($estudiante) {
        if (empty($estudiante->codigo)) {
            $ultimo = static::max('id') + 1;
            $estudiante->codigo = 'E' . date('Y') . str_pad($ultimo, 4, '0', STR_PAD_LEFT);
        }
    });
}
}
