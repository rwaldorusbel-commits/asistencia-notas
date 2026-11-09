<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use App\Models\Matricula;
use App\Models\Nota;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    public function index()
    {
        $asignaciones = Asignacion::with(['curso', 'seccion'])->get();

        return view('notas.index', compact('asignaciones'));
    }

    public function show(Asignacion $asignacion)
    {
        $asignacion->load(['curso', 'seccion']);

        $matriculas = Matricula::with('estudiante')
            ->where('seccion_id', $asignacion->seccion_id)
            ->get();

        $notas = Nota::where('asignacion_id', $asignacion->id)
            ->orderBy('fecha')
            ->get()
            ->groupBy('matricula_id');

        return view('notas.show', compact('asignacion', 'matriculas', 'notas'));
    }

    public function store(Request $request, Asignacion $asignacion)
    {
        $data = $request->validate([
            'descripcion' => 'required|string|max:100',
            'peso'        => 'nullable|numeric|min:0|max:100',
            'fecha'       => 'required|date',
            'valores'     => 'required|array',
            'valores.*'   => 'nullable|numeric|min:0|max:20',
        ]);

        foreach ($data['valores'] as $matriculaId => $valor) {
            if ($valor === null || $valor === '') {
                continue; // sin nota para ese estudiante
            }

            Nota::create([
                'matricula_id'  => $matriculaId,
                'asignacion_id' => $asignacion->id,
                'descripcion'   => $data['descripcion'],
                'valor'         => $valor,
                'peso'          => $data['peso'] ?? 1,
                'fecha'         => $data['fecha'],
            ]);
        }

        return back()->with('message', 'Notas guardadas.');
    }

    public function destroy(Nota $nota)
    {
        $nota->delete();

        return back()->with('message', 'Nota eliminada.');
    }
}
