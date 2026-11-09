<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Estudiante extends Model
{
    protected $table = 'asis_estudiantes';

    protected $fillable = [
        'user_id', 'codigo', 'dni', 'apoderado_id',
        'nombres', 'apellidos', 'fecha_nacimiento', 'activo',
    ];

    protected $casts = [
        'activo'           => 'boolean',
        'fecha_nacimiento' => 'date',
    ];

    /* ---------- Relaciones ---------- */

    public function apoderado()
    {
        return $this->belongsTo(Apoderado::class, 'apoderado_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function matriculas()
    {
        return $this->hasMany(Matricula::class, 'estudiante_id');
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'estudiante_id');
    }

    public function notas()
    {
        return $this->hasMany(Nota::class, 'estudiante_id');
    }

    /* ---------- Eventos ---------- */

    protected static function booted()
    {
        // Genera el código si no viene
        static::creating(function ($estudiante) {
            if (empty($estudiante->codigo)) {
                $ultimo = static::max('id') + 1;
                $estudiante->codigo = 'E' . date('Y') . str_pad($ultimo, 4, '0', STR_PAD_LEFT);
            }
        });

        // Respaldo: si se crea un estudiante SIN user_id, se le genera un usuario
        static::created(function ($estudiante) {
            if ($estudiante->user_id) {
                return; // ya tiene usuario (el que creó el controlador con el correo real)
            }

            $user = new User();
            $user->name              = $estudiante->nombres . ' ' . $estudiante->apellidos;
            $user->email             = strtolower($estudiante->codigo) . '@estudiante.local';
            $user->password          = Hash::make($estudiante->dni ?: $estudiante->codigo);
            $user->rol               = 'estudiante';
            $user->activo            = true;
            $user->email_verified_at = now();
            $user->save();

            $estudiante->user_id = $user->id;
            $estudiante->saveQuietly();
        });
    }
}
