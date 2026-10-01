<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use App\Models\Curso;
use App\Models\Seccion;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AsignacionController extends Controller
{
    private function reglas(Request $r, ?Asignacion $a = null): array
    {
        return [
            'docente_id' => ['required', 'exists:users,id'],
            'curso_id'   => ['required', 'exists:asis_cursos,id'],
            'seccion_id' => ['required', 'exists:asis_secciones,id',
                Rule::unique('asis_asignaciones', 'seccion_id')
                    ->where('curso_id', $r->curso_id)
                    ->ignore($a?->id)],
        ];
    }

    private function listas(): array
    {
        return [
            'docentes'  => User::where('rol', 'docente')->where('activo', true)->orderBy('name')->get(),
            'cursos'    => Curso::where('activo', true)->orderBy('nombre')->get(),
            'secciones' => Seccion::with(['periodo', 'grado'])->where('activo', true)
                ->orderByDesc('periodo_id')->orderBy('grado_id')->orderBy('nombre')->get(),
        ];
    }

    public function index(Request $request)
    {
        $asignaciones = Asignacion::with(['docente', 'curso', 'seccion.grado', 'seccion.periodo'])
            ->when($request->seccion_id, fn ($q, $v) => $q->where('seccion_id', $v))
            ->orderByDesc('id')
            ->paginate(10)->withQueryString();

        return view('asignaciones.index', [
            'asignaciones' => $asignaciones,
            'secciones'    => $this->listas()['secciones'],
        ]);
    }

    public function create()
    {
        return view('asignaciones.create', $this->listas());
    }

    public function store(Request $request)
    {
        $d = $request->validate($this->reglas($request), [
            'seccion_id.unique' => 'Ese curso ya está asignado a esa sección.',
        ]);
        $d['activo'] = $request->boolean('activo');
        Asignacion::create($d);

        return redirect()->route('asignaciones.index')->with('ok', 'Asignación registrada.');
    }

    public function edit(Asignacion $asignacion)
    {
        return view('asignaciones.edit', ['asignacion' => $asignacion] + $this->listas());
    }

    public function update(Request $request, Asignacion $asignacion)
    {
        $d = $request->validate($this->reglas($request, $asignacion), [
            'seccion_id.unique' => 'Ese curso ya está asignado a esa sección.',
        ]);
        $d['activo'] = $request->boolean('activo');
        $asignacion->update($d);

        return redirect()->route('asignaciones.index')->with('ok', 'Asignación actualizada.');
    }

    public function destroy(Asignacion $asignacion)
    {
        try {
            $asignacion->delete();
        } catch (QueryException $e) {
            return back()->withErrors(['general' => 'No se puede eliminar: tiene asistencia o notas registradas. Desactívala en su lugar.']);
        }

        return redirect()->route('asignaciones.index')->with('ok', 'Asignación eliminada.');
    }
}
