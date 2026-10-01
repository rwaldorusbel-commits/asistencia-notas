@extends('layouts.panel')
@section('titulo', 'Justificar inasistencia')

@section('contenido')
    <div class="encabezado"><h1>Justificar inasistencia</h1></div>
    <div class="tarjeta">
        <p>
            <strong>{{ $asistencia->matricula->estudiante->apellidos }}, {{ $asistencia->matricula->estudiante->nombres }}</strong><br>
            {{ $asistencia->asignacion->curso->nombre }} - {{ $asistencia->fecha->format('d/m/Y') }}
            ({{ ucfirst($asistencia->estado) }})
        </p>

        <form method="POST" action="{{ route('justificaciones.store', $asistencia) }}">
            @csrf
            <label>Motivo</label>
            <textarea name="motivo" rows="4" maxlength="500" required>{{ old('motivo') }}</textarea>
            @error('motivo') <small style="color:#dc2626">{{ $message }}</small> @enderror

            <div class="acciones">
                <button class="btn">Guardar justificación</button>
                <a href="{{ route('historial.index') }}" class="btn btn-chico">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
