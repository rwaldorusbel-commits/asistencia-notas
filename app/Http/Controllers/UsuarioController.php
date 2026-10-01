<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    private const ROLES = ['admin', 'docente', 'estudiante', 'apoderado'];

    public function index(Request $request)
    {
        $usuarios = User::query()
            ->when($request->q, function ($query, $buscar) {
                $query->where(function ($w) use ($buscar) {
                    $w->where('name', 'like', "%{$buscar}%")
                      ->orWhere('email', 'like', "%{$buscar}%");
                });
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('usuarios.create', ['roles' => self::ROLES]);
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'rol'      => ['required', Rule::in(self::ROLES)],
        ]);

        $datos['password'] = Hash::make($datos['password']);
        $datos['activo'] = true;

        User::create($datos);

        return redirect()->route('usuarios.index')->with('ok', 'Usuario creado correctamente.');
    }

    public function edit(User $usuario)
    {
        return view('usuarios.edit', ['usuario' => $usuario, 'roles' => self::ROLES]);
    }

    public function update(Request $request, User $usuario)
    {
        $datos = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($usuario->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'rol'      => ['required', Rule::in(self::ROLES)],
        ]);

        // No permitir que el admin se quite su propio rol
        if ($usuario->id === Auth::id()) {
            $datos['rol'] = $usuario->rol;
        }

        if (empty($datos['password'])) {
            unset($datos['password']);
        } else {
            $datos['password'] = Hash::make($datos['password']);
        }

        $usuario->update($datos);

        return redirect()->route('usuarios.index')->with('ok', 'Usuario actualizado.');
    }

    // Desactivar (no se borra)
    public function destroy(User $usuario)
    {
        if ($usuario->id === Auth::id()) {
            return back()->withErrors(['usuario' => 'No puedes desactivar tu propio usuario.']);
        }

        $usuario->update(['activo' => false]);

        return redirect()->route('usuarios.index')->with('ok', 'Usuario desactivado.');
    }

    public function activar(User $usuario)
    {
        $usuario->update(['activo' => true]);

        return redirect()->route('usuarios.index')->with('ok', 'Usuario activado.');
    }
}
