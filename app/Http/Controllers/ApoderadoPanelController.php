<?php

namespace App\Http\Controllers;

class ApoderadoPanelController extends Controller
{
    public function hijos()
    {
        return view('apoderado.hijos');
    }

    public function asistencia()
    {
        return view('apoderado.asistencia');
    }

    public function notas()
    {
        return view('apoderado.notas');
    }
}
