@extends('layouts.panel')
@section('titulo', 'Historial de asistencia')

@section('contenido')
    <div class="encabezado"><h1>Historial de asistencia</h1></div>

    <div class="tarjeta">
        @if ($errors->any())
            <p style="color:#dc2626">{{ $errors->first() }}</p>
        @endif

        <form method="GET" style="margin-bottom:12px">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Estudiante o código">
            <select name="asignacion_id">
                <option value="">Todos los cursos</option>
                @foreach ($asignaciones as $a)
                    <option value="{{ $a->id }}" {{ request('asignacion_id') == $a->id ? 'selected' : '' }}>
                        {{ $a->seccion->periodo->nombre }} - {{ $a->seccion->grado->nombre ?? '' }}
                        {{ $a->seccion->nombre }} - {{ $a->curso->nombre }}
                    </option>
                @endforeach
            </select>
            <input type="date" name="desde" value="{{ request('desde') }}">
            <input type="date" name="hasta" value="{{ request('hasta') }}">
            <button type="submit">Filtrar</button>
        </form>

        <p>
            <strong>Total:</strong> {{ $total }} |
            Presente: {{ $resumen['presente'] ?? 0 }} |
            Tarde: {{ $resumen['tarde'] ?? 0 }} |
            Falta: {{ $resumen['falta'] ?? 0 }} |
            Justificado: {{ $resumen['justificado'] ?? 0 }}
            @if (! is_null($porcentaje)) | <strong>Asistencia: {{ $porcentaje }}%</strong> @endif
        </p>

        <div class="tabla-wrap">
            <table>
                <thead>
                    <tr><th>Fecha</th><th>Estudiante</th><th>Curso</th><th>Sección</th><th>Estado</th><th>Observación / Motivo</th><th>Acciones</th></tr>
                </thead>
                <tbody>
                @forelse ($registros as $r)
                    <tr>
                        <td>{{ $r->fecha->format('d/m/Y') }}</td>
                        <td>{{ $r->matricula->estudiante->apellidos }}, {{ $r->matricula->estudiante->nombres }}</td>
                        <td>{{ $r->asignacion->curso->nombre }}</td>
                        <td>{{ $r->asignacion->seccion->grado->nombre ?? '' }} {{ $r->asignacion->seccion->nombre }}</td>
                        <td>{{ ucfirst($r->estado) }}</td>
                        <td>{{ $r->justificacion->motivo ?? $r->observacion ?? '-' }}</td>
                        <td>
                            @if (in_array($r->estado, ['falta', 'tarde']))
                                <a href="{{ route('justificaciones.create', $r) }}" class="btn btn-chico">Justificar</a>
                            @elseif ($r->justificacion)
                                <form method="POST" action="{{ route('justificaciones.destroy', $r) }}"
                                      onsubmit="return confirm('¿Quitar la justificación?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-chico btn-rojo">Quitar</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" style="text-align:center;color:#94a3b8">No hay registros con esos filtros.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="paginacion">{{ $registros->links() }}</div>
    </div>
@endsection
