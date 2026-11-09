<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function formCorreo()
    {
        return view('auth.olvide');
    }

 public function enviarEnlace(Request $request)
{
    $request->validate(['email' => 'required|email']);

    Password::sendResetLink($request->only('email'));

    // Mismo mensaje exista o no el correo
    return back()->with('message', 'Si el correo está registrado, te enviamos un enlace de recuperación.');
}
    public function formReset(Request $request, string $token)
    {
        return view('auth.reset', ['token' => $token, 'email' => $request->email]);
    }

    public function actualizar(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password'       => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('message', 'Contraseña actualizada. Ya puedes iniciar sesión.')
            : back()->withErrors(['email' => 'El enlace es inválido o expiró.']);
    }
}
