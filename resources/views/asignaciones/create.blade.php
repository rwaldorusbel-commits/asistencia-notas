@extends('layouts.panel')
@section('titulo', 'Nueva asignación')

@section('contenido')
    <div class="encabezado"><h1>👩‍🏫 Nueva asignación</h1></div>
    <div class="tarjeta">
        <form method="POST" action="{{ route('asignaciones.store') }}">
            @include('asignaciones._form')
        </form>
    </div>
@endsection
