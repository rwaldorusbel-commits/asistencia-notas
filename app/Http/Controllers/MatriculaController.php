<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Matricula;
use App\Models\Periodo;
use App\Models\Seccion;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MatriculaController extends Controller
{
    private function secciones()
    {
        return Seccion::with(['periodo', 'grado'])
            ->where('activo', true)
            ->orderByDesc('periodo_id')
            ->orderBy('grado_id')
            ->orderBy('nombre')
            ->get();
    }

    /** Devuelve un mensaje de error si la sección ya no tiene cupo. */
    private function errorDeCupo(Seccion $seccion, ?Matricula $actual = null): ?string
    {
        $ocupados = Matricula::where('seccion_id', $seccion->id)
            ->where('estado', 'matriculado')
            ->when($actual, fn ($q) => $q->where('id', '!=', $actual->id))
            ->count();

        return $ocupados >= $seccion->capacidad
            ? "La sección {$seccion->grado?->nombre} {$seccion->nombre} ya alcanzó su capacidad ({$seccion->capacidad})."
            : null;
    }

    public function index(Request $request)
    {
        $matriculas = Matricula::with(['estudiante', 'seccion.grado', 'periodo'])
            ->when($request->periodo_id, fn ($q, $v) => $q->where('periodo_id', $v))
            ->when($request->seccion_id, fn ($q, $v) => $q->where('seccion_id', $v))
            ->orderByDesc('id')
            ->paginate(10)->withQueryString();

        return view('matriculas.index', [
            'matriculas' => $matriculas,
            'periodos'   => Periodo::orderByDesc('anio')->get(),
            'secciones'  => Seccion::with(['periodo', 'grado'])->orderBy('grado_id')->orderBy('nombre')->get(),
        ]);
    }

    public function create()
    {
        return view('matriculas.create', [
            'estudiantes' => Estudiante::where('activo', true)->orderBy('apellidos')->orderBy('nombres')->get(),
            'secciones'   => $this->secciones(),
        ]);
    }

    public function store(Request $request)
    {
        $d = $request->validate([
            'estudiante_id'   => ['required', 'exists:asis_estudiantes,id'],
            'seccion_id'      => ['required', 'exists:asis_secciones,id'],
            'fecha_matricula' => ['required', 'date'],
        ]);

        $error = null;

        DB::transaction(function () use ($d, &$error) {
            $seccion = Seccion::with('grado')->lockForUpdate()->findOrFail($d['seccion_id']);

            if (! $seccion->activo) {
                $error = ['seccion_id' => 'La sección está inactiva.'];
                return;
            }

            if (! Estudiante::where('id', $d['estudiante_id'])->where('activo', true)->exists()) {
                $error = ['estudiante_id' => 'El estudiante está inactivo.'];
                return;
            }

            if (Matricula::where('estudiante_id', $d['estudiante_id'])
                    ->where('periodo_id', $seccion->periodo_id)->exists()) {
                $error = ['estudiante_id' => 'El estudiante ya tiene una matrícula en ese periodo. Edítala si necesitas cambiarla.'];
                return;
            }

            if ($msg = $this->errorDeCupo($seccion)) {
                $error = ['seccion_id' => $msg];
                return;
            }

            Matricula::create([
                'estudiante_id'   => $d['estudiante_id'],
                'seccion_id'      => $seccion->id,
                'periodo_id'      => $seccion->periodo_id,
                'fecha_matricula' => $d['fecha_matricula'],
                'estado'          => 'matriculado',
            ]);
        });

        if ($error) {
            return back()->withInput()->withErrors($error);
        }

        return redirect()->route('matriculas.index')->with('ok', 'Matrícula registrada correctamente.');
    }

    public function edit(Matricula $matricula)
    {
        $matricula->load('estudiante');

        return view('matriculas.edit', [
            'matricula' => $matricula,
            // Solo secciones del mismo periodo de la matrícula
            'secciones' => $this->secciones()->where('periodo_id', $matricula->periodo_id),
        ]);
    }

    public function update(Request $request, Matricula $matricula)
    {
        $d = $request->validate([
            'seccion_id'      => ['required', 'exists:asis_secciones,id'],
            'fecha_matricula' => ['required', 'date'],
            'estado'          => ['required', 'in:matriculado,retirado'],
        ]);

        $error = null;

        DB::transaction(function () use ($d, $matricula, &$error) {
            $seccion = Seccion::with('grado')->lockForUpdate()->findOrFail($d['seccion_id']);

            if ($seccion->periodo_id !== $matricula->periodo_id) {
                $error = ['seccion_id' => 'La sección debe pertenecer al mismo periodo de la matrícula.'];
                return;
            }

            if ($d['estado'] === 'matriculado' && ($msg = $this->errorDeCupo($seccion, $matricula))) {
                $error = ['seccion_id' => $msg];
                return;
            }

            $matricula->update($d);
        });

        if ($error) {
            return back()->withInput()->withErrors($error);
        }

        return redirect()->route('matriculas.index')->with('ok', 'Matrícula actualizada.');
    }

    public function destroy(Matricula $matricula)
    {
        try {
            $matricula->delete();
        } catch (QueryException $e) {
            return back()->withErrors(['general' => 'No se puede eliminar: la matrícula tiene registros asociados. Cambia su estado a "retirado".']);
        }

        return redirect()->route('matriculas.index')->with('ok', 'Matrícula eliminada.');
    }
}
