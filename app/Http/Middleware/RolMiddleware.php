<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RolMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        // Normaliza para que "Estudiante", "estudiante " o "ESTUDIANTE" funcionen igual
        $rolUsuario = strtolower(trim((string) $user->rol));
        $permitidos = array_map(fn ($r) => strtolower(trim($r)), $roles);

        if (!in_array($rolUsuario, $permitidos)) {
            abort(403, 'No tienes permiso para entrar aquí.');
        }

        return $next($request);

        Route::get('/perfil', [ProfileController::class, 'edit'])->name('perfil.index');
    }

}
