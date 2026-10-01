@extends('layouts.panel')
@section('titulo', 'Nuevo periodo')

@section('contenido')
    <div class="encabezado"><h1>📅 Nuevo periodo</h1></div>
    <div class="tarjeta">
        <form method="POST" action="{{ route('periodos.store') }}">
            @include('periodos._form')
        </form>
    </div>
@endsection
