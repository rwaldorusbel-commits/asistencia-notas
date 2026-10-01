@extends('layouts.panel')
@section('titulo', 'Editar curso')

@section('contenido')
    <div class="encabezado"><h1>📚 Editar curso</h1></div>
    <div class="tarjeta">
        <form method="POST" action="{{ route('cursos.update', $curso) }}">
            @method('PUT')
            @include('cursos._form')
        </form>
    </div>
@endsection
