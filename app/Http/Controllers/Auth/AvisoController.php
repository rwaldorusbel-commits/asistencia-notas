<?php

namespace App\Http\Controllers;

use App\Mail\AvisoGeneral;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AvisoController extends Controller
{
    public function formulario()
    {
        return view('ajustes.aviso');
    }

    public function enviar(Request $request)
    {
        $request->validate(['mensaje' => 'required|string|max:1000']);

        $enviados = 0;

        foreach (User::whereNotNull('email')->get() as $user) {
            Mail::to($user->email)->send(
                new AvisoGeneral('Hola ' . $user->name . ', ' . $request->mensaje)
            );
            $enviados++;
        }

        return back()->with('message', "Aviso enviado a {$enviados} usuarios.");
    }
}
