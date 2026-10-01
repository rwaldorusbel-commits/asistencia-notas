@extends('layouts.panel')
@section('titulo', 'Matrículas')

@section('contenido')
    <div class="encabezado">
        <h1>📝 Matrículas</h1>
        <a href="{{ route('matriculas.create') }}" class="btn">+ Nueva matrícula</a>
    </div>

    <div class="tarjeta">
        <form method="GET" style="margin-bottom:12px">
            <select name="periodo_id">
                <option value="">Todos los periodos</option>
                @foreach ($periodos as $p)
                    <option value="{{ $p->id }}" @selected(request('periodo_id') == $p->id)>{{ $p->nombre }}</option>
                @endforeach
            </select>
            <select name="seccion_id">
                <option value="">Todas las secciones</option>
                @foreach ($secciones as $s)
                    <option value="{{ $s->id }}" @selected(request('seccion_id') == $s->id)>
                       {{ $s->grado->nombre ?? '' }} {{ $s->nombre }} {{ $s->nombre }}
                    </option>
                @endforeach
            </select>
            <button type="submit">Filtrar</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Periodo</th><th>Estudiante</th><th>Grado y sección</th>
                    <th>Fecha</th><th>Estado</th><th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($matriculas as $m)
                    <tr>
                        <td>{{ $m->periodo->nombre ?? '-' }}</td>
                        <td>{{ $m->estudiante->apellidos ?? '' }}, {{ $m->estudiante->nombres ?? '' }}</td>
                       <td>{{ $m->seccion->grado->nombre ?? '' }} {{ $m->seccion->nombre }}</td>
                        <td>{{ $m->fecha_matricula->format('d/m/Y') }}</td>
                        <td>{{ ucfirst($m->estado) }}</td>
                        <td>
                            <a href="{{ route('matriculas.edit', $m) }}">Editar</a>
                            <form method="POST" action="{{ route('matriculas.destroy', $m) }}"
                                  style="display:inline" onsubmit="return confirm('¿Eliminar esta matrícula?')">
                                @csrf @method('DELETE')
                                <button type="submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6">No hay matrículas registradas.</td></tr>
                @endforelse
            </tbody>
        </table>

        {{ $matriculas->links() }}
    </div>
@endsection
