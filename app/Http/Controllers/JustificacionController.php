<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Justificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class JustificacionController extends Controller
{
   private function autorizar(Asistencia $asistencia): void
{
    $asistencia->loadMissing('asignacion');
    $esAdmin = Auth::user()->rol === 'admin'; // AJUSTAR si tu rol se llama distinto

    abort_unless($esAdmin || $asistencia->asignacion->docente_id === Auth::id(), 403);
}

    public function create(Asistencia $asistencia)
    {
        $this->autorizar($asistencia);

        if (! in_array($asistencia->estado, ['falta', 'tarde'], true)) {
            return redirect()->route('historial.index')
                ->withErrors(['general' => 'Solo se justifican faltas o tardanzas sin justificar.']);
        }

        $asistencia->load(['matricula.estudiante', 'asignacion.curso']);

        return view('justificaciones.create', compact('asistencia'));
    }

    public function store(Request $request, Asistencia $asistencia)
    {
        $this->autorizar($asistencia);

        $d = $request->validate(['motivo' => ['required', 'string', 'max:500']]);

        if (! in_array($asistencia->estado, ['falta', 'tarde'], true)) {
            return redirect()->route('historial.index')
                ->withErrors(['general' => 'Esta asistencia no se puede justificar.']);
        }

      DB::transaction(function () use ($asistencia, $d) {
    Justificacion::create([
        'asistencia_id'   => $asistencia->id,
        'estado_original' => $asistencia->estado,
        'motivo'          => $d['motivo'],
        'registrado_por'  => Auth::id(),
    ]);
    $asistencia->update(['estado' => 'justificado']);
});

        return redirect()->route('historial.index')->with('ok', 'Justificación registrada.');
    }

    public function destroy(Asistencia $asistencia)
    {
        $this->autorizar($asistencia);

        $j = Justificacion::where('asistencia_id', $asistencia->id)->first();

        if ($j) {
            DB::transaction(function () use ($asistencia, $j) {
                $asistencia->update(['estado' => $j->estado_original]);
                $j->delete();
            });
        }

        return back()->with('ok', 'Justificación eliminada.');
    }
}
