@extends('layouts.panel')
@section('titulo', 'Editar matrícula')

@section('contenido')
    <div class="encabezado"><h1>📝 Editar matrícula</h1></div>
    <div class="tarjeta">
        <form method="POST" action="{{ route('matriculas.update', $matricula) }}">
            @csrf
            @method('PUT')

            <p><strong>Estudiante:</strong>
                {{ $matricula->estudiante->apellidos }}, {{ $matricula->estudiante->nombres }}</p>

            <div class="campo">
                <label for="seccion_id">Sección</label>
                <select name="seccion_id" id="seccion_id" required>
                    @foreach ($secciones as $s)
                        <option value="{{ $s->id }}" @selected(old('seccion_id', $matricula->seccion_id) == $s->id)>
                            {{ $s->periodo->nombre ?? '' }} - {{ $s->grado->nombre ?? '' }} {{ $s->nombre }}
                    @endforeach
                </select>
                @error('seccion_id') <small class="error">{{ $message }}</small> @enderror
            </div>

            <div class="campo">
                <label for="fecha_matricula">Fecha de matrícula</label>
                <input type="date" name="fecha_matricula" id="fecha_matricula" required
                       value="{{ old('fecha_matricula', $matricula->fecha_matricula->format('Y-m-d')) }}">
                @error('fecha_matricula') <small class="error">{{ $message }}</small> @enderror
            </div>

            <div class="campo">
                <label for="estado">Estado</label>
                <select name="estado" id="estado" required>
                    @foreach (['matriculado', 'retirado'] as $e)
                        <option value="{{ $e }}" @selected(old('estado', $matricula->estado) == $e)>{{ ucfirst($e) }}</option>
                    @endforeach
                </select>
                @error('estado') <small class="error">{{ $message }}</small> @enderror
            </div>

            <button type="submit" class="btn">Guardar</button>
            <a href="{{ route('matriculas.index') }}">Cancelar</a>
        </form>
    </div>
@endsection
