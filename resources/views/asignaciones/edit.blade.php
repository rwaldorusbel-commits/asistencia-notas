@extends('layouts.panel')
@section('titulo', 'Editar asignación')

@section('contenido')
    <div class="encabezado"><h1>👩‍🏫 Editar asignación</h1></div>
    <div class="tarjeta">
        <form method="POST" action="{{ route('asignaciones.update', $asignacion) }}">
            @method('PUT')
            @include('asignaciones._form')
        </form>
    </div>
@endsection
