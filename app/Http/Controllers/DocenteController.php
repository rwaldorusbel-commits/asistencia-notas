<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class DocenteController extends Controller
{
    private function reglas(?User $u = null): array
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($u?->id)],
            'password' => [$u ? 'nullable' : 'required', 'string', 'min:8'],
        ];
    }

    private function soloDocente(User $docente): void
    {
        abort_unless($docente->rol === 'docente', 404);
    }

    public function index(Request $request)
    {
        $docentes = User::where('rol', 'docente')
            ->when($request->q, fn ($q, $t) => $q->where(fn ($w) => $w
                ->where('name', 'like', "%$t%")
                ->orWhere('email', 'like', "%$t%")))
            ->orderBy('name')
            ->paginate(10)->withQueryString();

        return view('docentes.index', compact('docentes'));
    }

    public function create()
    {
        return view('docentes.create');
    }

    public function store(Request $request)
    {
        $d = $request->validate($this->reglas());

        $u = new User();
        $u->forceFill([
            'name'     => $d['name'],
            'email'    => $d['email'],
            'password' => Hash::make($d['password']),
            'rol'      => 'docente',
            'activo'   => $request->boolean('activo'),
        ])->save();

        return redirect()->route('docentes.index')->with('ok', 'Docente registrado.');
    }

    public function edit(User $docente)
    {
        $this->soloDocente($docente);

        return view('docentes.edit', compact('docente'));
    }

    public function update(Request $request, User $docente)
    {
        $this->soloDocente($docente);
        $d = $request->validate($this->reglas($docente));

        $datos = [
            'name'   => $d['name'],
            'email'  => $d['email'],
            'activo' => $request->boolean('activo'),
        ];
        if (! empty($d['password'])) {
            $datos['password'] = Hash::make($d['password']);
        }

        $docente->forceFill($datos)->save();

        return redirect()->route('docentes.index')->with('ok', 'Docente actualizado.');
    }

    public function destroy(User $docente)
    {
        $this->soloDocente($docente);

     $enUso = DB::table('asis_asignaciones')->where('docente_id', $docente->id)->exists();
        if ($enUso) {
            return back()->withErrors(['general' => 'No se puede eliminar: el docente tiene asignaciones. Desactívalo en su lugar.']);
        }

        $docente->delete();

        return redirect()->route('docentes.index')->with('ok', 'Docente eliminado.');
    }
}
