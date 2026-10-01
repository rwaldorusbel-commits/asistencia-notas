@extends('layouts.panel')
@section('titulo', 'Nueva sección')

@section('contenido')
    <div class="encabezado"><h1>🏫 Nueva sección</h1></div>
    <div class="tarjeta">
        <form method="POST" action="{{ route('secciones.store') }}">
            @include('secciones._form')
        </form>
    </div>
@endsection
