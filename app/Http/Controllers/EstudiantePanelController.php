<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Matricula;
use App\Models\Nota;
use App\Models\Estudiante;
use Illuminate\Support\Facades\Auth;

class EstudiantePanelController extends Controller
{
    /** Devuelve el estudiante del usuario logueado o aborta con 403. */
    private function estudianteActual(): Estudiante
    {
        $estudiante = Auth::user()->estudiante;

        abort_if(!$estudiante, 403, 'Tu usuario no está vinculado a un estudiante.');

        return $estudiante;
    }

    public function cursos()
    {
        $estudiante = $this->estudianteActual();

        $matriculas = Matricula::with(['seccion', 'periodo'])
            ->where('estudiante_id', $estudiante->id)
            ->get();

        return view('estudiante.cursos', compact('estudiante', 'matriculas'));
    }

    public function notas()
    {
        $estudiante = $this->estudianteActual();

        $notas = Nota::with(['asignacion'])
            ->whereHas('matricula', function ($q) use ($estudiante) {
                $q->where('estudiante_id', $estudiante->id);
            })
            ->get();

        return view('estudiante.notas', compact('estudiante', 'notas'));
    }

    public function asistencia()
    {
        $estudiante = $this->estudianteActual();

        $asistencias = Asistencia::with(['justificacion', 'asignacion'])
            ->whereHas('matricula', function ($q) use ($estudiante) {
                $q->where('estudiante_id', $estudiante->id);
            })
            ->orderByDesc('fecha')
            ->get();

        $resumen = $asistencias->groupBy('estado')->map->count();

        return view('estudiante.asistencia', compact('estudiante', 'asistencias', 'resumen'));
    }
}
