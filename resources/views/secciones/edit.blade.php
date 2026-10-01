@extends('layouts.panel')
@section('titulo', 'Editar sección')

@section('contenido')
    <div class="encabezado"><h1>🏫 Editar sección</h1></div>
    <div class="tarjeta">
        <form method="POST" action="{{ route('secciones.update', $seccion) }}">
            @method('PUT')
            @include('secciones._form')
        </form>
    </div>
@endsection
