@extends('layouts.panel')
@section('titulo', 'Editar estudiante')

@section('contenido')
    <div class="encabezado"><h1>🧑 Editar estudiante</h1></div>
    <div class="tarjeta">
        <form method="POST" action="{{ route('estudiantes.update', $estudiante) }}">
            @include('estudiantes._form')
        </form>
    </div>
    <label>Correo del estudiante (con este inicia sesión)</label>
<input type="email" name="email"
       value="{{ old('email', $estudiante->user->email ?? '') }}">
@error('email') <small>{{ $message }}</small> @enderror
@endsection
