<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apoderado extends Model
{
    protected $table = 'asis_apoderados';

    protected $fillable = ['user_id', 'nombres', 'apellidos', 'dni', 'telefono', 'email'];
}
