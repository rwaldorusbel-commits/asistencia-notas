<?php

namespace App\Http\Controllers;

use App\Models\Periodo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PeriodoController extends Controller
{
    private const TIPOS = ['anual', 'semestre', 'bimestre'];

    private function reglas(?Periodo $periodo = null): array
    {
        return [
            'nombre'       => ['required', 'string', 'max:255'],
            'anio'         => ['required', 'integer', 'between:2000,2100',
                Rule::unique('asis_periodos')
                    ->where(fn ($q) => $q->where('nombre', request('nombre')))
                    ->ignore($periodo?->id)],
            'tipo'         => ['required', Rule::in(self::TIPOS)],
            'fecha_inicio' => ['required', 'date'],
            'fecha_fin'    => ['required', 'date', 'after:fecha_inicio'],
        ];
    }

   public function index()
{
    $periodos = Periodo::orderByDesc('anio')->paginate(10);

    return view('periodos.index', compact('periodos'));
}

    public function create()
    {
        return view('periodos.create', ['tipos' => self::TIPOS]);
    }

    public function store(Request $request)
    {
        $datos = $request->validate($this->reglas());
        $datos['activo'] = $request->boolean('activo');

        Periodo::create($datos);

        return redirect()->route('periodos.index')->with('ok', 'Periodo creado correctamente.');
    }

    public function edit(Periodo $periodo)
    {
        return view('periodos.edit', ['periodo' => $periodo, 'tipos' => self::TIPOS]);
    }

    public function update(Request $request, Periodo $periodo)
    {
        $datos = $request->validate($this->reglas($periodo));
        $datos['activo'] = $request->boolean('activo');

        $periodo->update($datos);

        return redirect()->route('periodos.index')->with('ok', 'Periodo actualizado.');
    }

    public function destroy(Periodo $periodo)
    {
        $enUso = DB::table('asis_secciones')->where('periodo_id', $periodo->id)->exists()
              || DB::table('asis_matriculas')->where('periodo_id', $periodo->id)->exists();

        if ($enUso) {
            return back()->withErrors(['general' => 'No se puede eliminar: el periodo ya tiene secciones o matrículas. Desactívalo en su lugar.']);
        }

        $periodo->delete();

        return redirect()->route('periodos.index')->with('ok', 'Periodo eliminado.');
    }
}
