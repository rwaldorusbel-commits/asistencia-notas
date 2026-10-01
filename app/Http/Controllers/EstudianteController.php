<?php

namespace App\Http\Controllers;

use App\Models\Apoderado;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class EstudianteController extends Controller
{
    private function reglas(?Estudiante $e = null): array
    {
        $apId = $e?->apoderado_id;

        return [
         'codigo' => ['nullable', 'string', 'max:20',
         Rule::unique('asis_estudiantes', 'codigo')->ignore($e?->id)],
            'dni'              => ['nullable', 'string', 'max:15',
                Rule::unique('asis_estudiantes', 'dni')->ignore($e?->id)],
            'nombres'          => ['required', 'string', 'max:255'],
            'apellidos'        => ['required', 'string', 'max:255'],
            'fecha_nacimiento' => ['nullable', 'date', 'before:today'],

            'ap_nombres'       => ['nullable', 'required_with:ap_apellidos,ap_dni', 'string', 'max:255'],
            'ap_apellidos'     => ['nullable', 'required_with:ap_nombres', 'string', 'max:255'],
            'ap_dni'           => ['nullable', 'string', 'max:15',
                Rule::unique('asis_apoderados', 'dni')->ignore($apId)],
            'ap_telefono'      => ['nullable', 'string', 'max:20'],
            'ap_email'         => ['nullable', 'email', 'max:255'],
        ];
    }

    private function guardarApoderado(array $d, ?Estudiante $e = null): ?int
    {
        if (empty($d['ap_nombres'])) {
            return $e?->apoderado_id;
        }

        $campos = [
            'nombres'   => $d['ap_nombres'],
            'apellidos' => $d['ap_apellidos'],
            'dni'       => $d['ap_dni'] ?? null,
            'telefono'  => $d['ap_telefono'] ?? null,
            'email'     => $d['ap_email'] ?? null,
        ];

        if ($e?->apoderado) {
            $e->apoderado->update($campos);
            return $e->apoderado_id;
        }

        return Apoderado::create($campos)->id;
    }

    private function datosEstudiante(array $d, Request $request, ?int $apoderadoId): array
    {
        return [
            'codigo'           => $d['codigo'],
            'dni'              => $d['dni'] ?? null,
            'nombres'          => $d['nombres'],
            'apellidos'        => $d['apellidos'],
            'fecha_nacimiento' => $d['fecha_nacimiento'] ?? null,
            'apoderado_id'     => $apoderadoId,
            'activo'           => $request->boolean('activo'),
        ];
    }

    public function index(Request $request)
    {
        $estudiantes = Estudiante::with('apoderado')
            ->when($request->q, fn ($q, $t) => $q->where(fn ($w) => $w
                ->where('nombres', 'like', "%$t%")
                ->orWhere('apellidos', 'like', "%$t%")
                ->orWhere('codigo', 'like', "%$t%")
                ->orWhere('dni', 'like', "%$t%")))
            ->orderBy('apellidos')->orderBy('nombres')
            ->paginate(10)->withQueryString();

        return view('estudiantes.index', compact('estudiantes'));
    }

    public function create()
    {
        return view('estudiantes.create');
    }

    public function store(Request $request)
    {
        $d = $request->validate($this->reglas());

        DB::transaction(function () use ($d, $request) {
            $apId = $this->guardarApoderado($d);
            Estudiante::create($this->datosEstudiante($d, $request, $apId));
        });

        return redirect()->route('estudiantes.index')->with('ok', 'Estudiante registrado correctamente.');
    }

    public function edit(Estudiante $estudiante)
    {
        $estudiante->load('apoderado');

        return view('estudiantes.edit', compact('estudiante'));
    }

    public function update(Request $request, Estudiante $estudiante)
    {
        $d = $request->validate($this->reglas($estudiante));

        DB::transaction(function () use ($d, $request, $estudiante) {
            $apId = $this->guardarApoderado($d, $estudiante);
            $estudiante->update($this->datosEstudiante($d, $request, $apId));
        });

        return redirect()->route('estudiantes.index')->with('ok', 'Estudiante actualizado.');
    }

    public function destroy(Estudiante $estudiante)
    {
        $enUso = Schema::hasTable('asis_matriculas')
            && DB::table('asis_matriculas')->where('estudiante_id', $estudiante->id)->exists();

        if ($enUso) {
            return back()->withErrors(['general' => 'No se puede eliminar: el estudiante tiene matrículas. Desactívalo en su lugar.']);
        }

        $estudiante->delete();

        return redirect()->route('estudiantes.index')->with('ok', 'Estudiante eliminado.');
    }
}
