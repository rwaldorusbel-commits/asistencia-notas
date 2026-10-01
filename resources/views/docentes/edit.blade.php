@extends('layouts.panel')
@section('titulo', 'Editar docente')

@section('contenido')
    <div class="encabezado"><h1>👨‍🏫 Editar docente</h1></div>
    <div class="tarjeta">
        <form method="POST" action="{{ route('docentes.update', $docente) }}">
            @method('PUT')
            @include('docentes._form')
        </form>
    </div>
@endsection
