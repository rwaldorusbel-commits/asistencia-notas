<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class CursoController extends Controller
{
    private function reglas(?Curso $curso = null): array
    {
        return [
            'codigo'      => ['required', 'string', 'max:20',
                Rule::unique('asis_cursos', 'codigo')->ignore($curso?->id)],
            'nombre'      => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function index()
    {
        $cursos = Curso::orderBy('nombre')->paginate(10);

        return view('cursos.index', compact('cursos'));
    }

    public function create()
    {
        return view('cursos.create');
    }

    public function store(Request $request)
    {
        $datos = $request->validate($this->reglas());
        $datos['activo'] = $request->boolean('activo');

        Curso::create($datos);

        return redirect()->route('cursos.index')->with('ok', 'Curso creado correctamente.');
    }

    public function edit(Curso $curso)
    {
        return view('cursos.edit', compact('curso'));
    }

    public function update(Request $request, Curso $curso)
    {
        $datos = $request->validate($this->reglas($curso));
        $datos['activo'] = $request->boolean('activo');

        $curso->update($datos);

        return redirect()->route('cursos.index')->with('ok', 'Curso actualizado.');
    }

    public function destroy(Curso $curso)
    {
        // Se activa cuando exista la tabla de asignaciones (RF07)
        $enUso = Schema::hasTable('asis_asignaciones')
            && DB::table('asis_asignaciones')->where('curso_id', $curso->id)->exists();

        if ($enUso) {
            return back()->withErrors(['general' => 'No se puede eliminar: el curso ya está asignado a docentes. Desactívalo en su lugar.']);
        }

        $curso->delete();

        return redirect()->route('cursos.index')->with('ok', 'Curso eliminado.');
    }
}
