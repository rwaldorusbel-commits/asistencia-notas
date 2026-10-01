@extends('layouts.panel')
@section('titulo', 'Asignaciones')

@section('contenido')
    <div class="encabezado">
        <h1>👩‍🏫 Asignación de docentes</h1>
        <a href="{{ route('asignaciones.create') }}" class="btn">+ Nueva asignación</a>
    </div>

    <div class="tarjeta">
        <form method="GET" style="margin-bottom:12px">
            <select name="seccion_id">
                <option value="">Todas las secciones</option>
                @foreach ($secciones as $s)
                    <option value="{{ $s->id }}" {{ request('seccion_id') == $s->id ? 'selected' : '' }}>
                        {{ $s->periodo->nombre }} - {{ $s->grado->nombre ?? '' }} {{ $s->nombre }}
                    </option>
                @endforeach
            </select>
            <button type="submit">Filtrar</button>
        </form>

        <div class="tabla-wrap">
            <table>
                <thead>
                    <tr><th>Periodo</th><th>Grado y sección</th><th>Curso</th><th>Docente</th><th>Estado</th><th>Acciones</th></tr>
                </thead>
                <tbody>
                @forelse ($asignaciones as $a)
                    <tr>
                        <td>{{ $a->seccion->periodo->nombre ?? '-' }}</td>
                        <td>{{ $a->seccion->grado->nombre ?? '' }} {{ $a->seccion->nombre }}</td>
                        <td>{{ $a->curso->nombre }}</td>
                        <td>{{ $a->docente->name ?? '-' }}</td>
                        <td>
                            <span class="badge {{ $a->activo ? 'badge-verde' : 'badge-rojo' }}">
                                {{ $a->activo ? 'Activa' : 'Inactiva' }}
                            </span>
                        </td>
                        <td>
                            <div class="acciones">
                                <a href="{{ route('asignaciones.edit', $a) }}" class="btn btn-chico">Editar</a>
                                <form method="POST" action="{{ route('asignaciones.destroy', $a) }}"
                                      onsubmit="return confirm('¿Eliminar esta asignación?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-chico btn-rojo">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center;color:#94a3b8">Aún no hay asignaciones.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="paginacion">{{ $asignaciones->links() }}</div>
    </div>
@endsection
