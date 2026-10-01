<?php

namespace App\Models;
use App\Models\Grado;


use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{
    protected $table = 'asis_secciones';

    protected $fillable = ['periodo_id', 'grado_id', 'nombre', 'capacidad', 'activo'];

    protected $casts = ['activo' => 'boolean'];

    public function periodo()
    {
        return $this->belongsTo(Periodo::class, 'periodo_id');
    }
public function grado()
{
    return $this->belongsTo(Grado::class, 'grado_id');
}

}
