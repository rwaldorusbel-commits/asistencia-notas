<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use App\Models\Asistencia;
use App\Models\Matricula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsistenciaController extends Controller
{
    private function asignacionesDelUsuario()
    {
        $usuario = Auth::user();
        $esAdmin = $usuario && $usuario->rol === 'admin';

        return Asignacion::with(['curso', 'seccion.grado'])
            ->when(! $esAdmin, fn ($q) => $q->where('docente_id', Auth::id()))
            ->get();
    }

    public function create(Request $request)
    {
        $asignaciones = $this->asignacionesDelUsuario();
        $fecha = $request->input('fecha', now()->toDateString());
        $asignacion = $asignaciones->firstWhere('id', (int) $request->asignacion_id);

        $matriculas = collect();
        $existentes = collect();

        if ($asignacion) {
            $matriculas = Matricula::with('estudiante')
                ->where('seccion_id', $asignacion->seccion_id)
                ->get()
                ->sortBy('estudiante.apellidos');

            $existentes = Asistencia::where('asignacion_id', $asignacion->id)
                ->whereDate('fecha', $fecha)
                ->pluck('estado', 'matricula_id');
        }

        return view('asistencia.create', compact(
            'asignaciones', 'asignacion', 'fecha', 'matriculas', 'existentes'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'asignacion_id' => ['required', 'integer'],
            'fecha'         => ['required', 'date'],
            'estados'       => ['required', 'array'],
            'estados.*'     => ['in:presente,tarde,falta'],
        ]);

        $asignacion = $this->asignacionesDelUsuario()->firstWhere('id', $data['asignacion_id']);
        abort_unless($asignacion, 403);

        $validas = Matricula::where('seccion_id', $asignacion->seccion_id)->pluck('id')->all();

        foreach ($data['estados'] as $matriculaId => $estado) {
            if (! in_array((int) $matriculaId, $validas)) {
                continue;
            }

            Asistencia::updateOrCreate(
                [
                    'asignacion_id' => $asignacion->id,
                    'matricula_id'  => $matriculaId,
                    'fecha'         => $data['fecha'],
                ],
                ['estado' => $estado]
            );
        }

        return back()->with('status', 'Asistencia guardada.');
    }
}
