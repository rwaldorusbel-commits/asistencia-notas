@extends('layouts.panel')
@section('titulo', 'Inicio')

@section('contenido')
    <div class="encabezado">
        <h1>🏠 Inicio</h1>
    </div>

    <div class="tarjeta">
        Bienvenido, {{ auth()->user()->name }}.
    </div>
@endsection
