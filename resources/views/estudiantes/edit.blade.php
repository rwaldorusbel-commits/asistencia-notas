@extends('layouts.panel')
@section('titulo', 'Editar estudiante')

@section('contenido')
    <div class="encabezado"><h1>🧑‍🎓 Editar estudiante</h1></div>
    <div class="tarjeta">
        <form method="POST" action="{{ route('estudiantes.update', $estudiante) }}">
            @include('estudiantes._form')
        </form>
    </div>
@endsection
