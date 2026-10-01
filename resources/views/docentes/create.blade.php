@extends('layouts.panel')
@section('titulo', 'Nuevo docente')

@section('contenido')
    <div class="encabezado"><h1>👨‍🏫 Nuevo docente</h1></div>
    <div class="tarjeta">
        <form method="POST" action="{{ route('docentes.store') }}">
            @include('docentes._form')
        </form>
    </div>
@endsection
