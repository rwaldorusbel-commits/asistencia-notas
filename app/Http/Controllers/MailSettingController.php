<?php

namespace App\Http\Controllers;

use App\Models\MailSetting;
use Illuminate\Http\Request;

class MailSettingController extends Controller
{
    public function edit()
    {
        return view('ajustes.correo', ['m' => MailSetting::first()]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'username'  => 'required|email',
            'password'  => 'nullable|string',
            'from_name' => 'nullable|string',
        ]);

        $setting = MailSetting::first() ?? new MailSetting();

        // Si no escribe contraseña, se conserva la anterior
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = str_replace(' ', '', $data['password']);
        }

        $setting->fill($data)->save();

        return back()->with('message', 'Configuración de Gmail guardada.');
    }
}
