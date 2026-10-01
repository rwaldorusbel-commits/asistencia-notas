@extends('layouts.panel')
@section('titulo', 'Nuevo curso')

@section('contenido')
    <div class="encabezado"><h1>📚 Nuevo curso</h1></div>
    <div class="tarjeta">
        <form method="POST" action="{{ route('cursos.store') }}">
            @include('cursos._form')
        </form>
    </div>
@endsection
