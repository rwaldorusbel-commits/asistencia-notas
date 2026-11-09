@extends('layouts.panel')
@section('titulo', 'Nuevo estudiante')

@section('contenido')
    <div class="encabezado"><h1>🧑 Nuevo estudiante</h1></div>
    <div class="tarjeta">
        <form method="POST" action="{{ route('estudiantes.store') }}">
            @include('estudiantes._form')
        </form>
    </div>
@endsection
