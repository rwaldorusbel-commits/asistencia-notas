<?php

namespace App\Http\Controllers;

use App\Models\Periodo;
use App\Models\Seccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use App\Models\Grado;

class SeccionController extends Controller
{
    private function reglas(?Seccion $seccion = null): array
    {
        return [
            'periodo_id' => ['required', 'exists:asis_periodos,id'],
            'grado_id:'      => ['required', 'string', 'max:60'],
            'nombre'     => ['required', 'string', 'max:20',
                Rule::unique('asis_secciones')
                    ->where(fn ($q) => $q->where('periodo_id', request('periodo_id'))
                                         ->where('grado_id', request('grado_id')))
                    ->ignore($seccion?->id)],
            'capacidad'  => ['required', 'integer', 'between:1,100'],
        ];
    }

    public function index()
    {
       $secciones = Seccion::with(['periodo', 'grado'])
    ->orderByDesc('periodo_id')
    ->orderBy('grado_id')
    ->orderBy('nombre')
    ->paginate(10);

        return view('secciones.index', compact('secciones'));
    }

   public function create()
{
    return view('secciones.create', [
        'periodos' => Periodo::orderByDesc('anio')->get(),
        'grados'   => Grado::orderBy('id')->get(),
    ]);
}

   public function store(Request $request)
{
    $data = $request->validate([
        'periodo_id' => ['required', 'exists:asis_periodos,id'],
        'grado_id'   => 'required|integer',
        'nombre'     => [
            'required',
            Rule::unique('asis_secciones', 'nombre')
                ->where('periodo_id', $request->periodo_id)
                ->where('grado_id', $request->grado_id),
        ],
        'capacidad'  => 'required|integer',
        'activo'     => 'required|boolean',
    ]);

    Seccion::create($data);

    return redirect()->back()->with('success', 'Sección creada');
}

    public function edit(Seccion $seccion)
    {
        return view('secciones.edit', [
            'seccion'  => $seccion,
            'periodos' => Periodo::orderByDesc('anio')->get(),
        ]);
    }

    public function update(Request $request, Seccion $seccion)
    {
        $datos = $request->validate($this->reglas($seccion));
        $datos['activo'] = $request->boolean('activo');

        $seccion->update($datos);

        return redirect()->route('secciones.index')->with('ok', 'Sección actualizada.');
    }

    public function destroy(Seccion $seccion)
    {
        $enUso = collect(['asis_matriculas', 'asis_asignaciones'])->contains(
            fn ($t) => Schema::hasTable($t)
                && DB::table($t)->where('seccion_id', $seccion->id)->exists()
        );

        if ($enUso) {
            return back()->withErrors(['general' => 'No se puede eliminar: la sección tiene matrículas o asignaciones. Desactívala en su lugar.']);
        }

        $seccion->delete();

        return redirect()->route('secciones.index')->with('ok', 'Sección eliminada.');
    }
}
