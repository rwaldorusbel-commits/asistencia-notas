@extends('layouts.panel')
@section('titulo', 'Estudiantes')

@section('contenido')
    <div class="encabezado">
        <h1>🧑‍🎓 Estudiantes</h1>
        <a href="{{ route('estudiantes.create') }}" class="btn">+ Nuevo estudiante</a>
    </div>

    <div class="tarjeta">
        <form method="GET" style="margin-bottom:12px">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar por nombre, código o DNI">
            <button type="submit">Buscar</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Código</th><th>Apellidos y nombres</th><th>DNI</th>
                    <th>Apoderado</th><th>Estado</th><th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($estudiantes as $e)
                    <tr>
                        <td>{{ $e->codigo }}</td>
                        <td>{{ $e->apellidos }}, {{ $e->nombres }}</td>
                        <td>{{ $e->dni ?? '-' }}</td>
                        <td>{{ $e->apoderado ? $e->apoderado->apellidos.', '.$e->apoderado->nombres : '-' }}</td>
                        <td>{{ $e->activo ? 'Activo' : 'Inactivo' }}</td>
                        <td>
                            <a href="{{ route('estudiantes.edit', $e) }}">Editar</a>
                            <form method="POST" action="{{ route('estudiantes.destroy', $e) }}"
                                  style="display:inline" onsubmit="return confirm('¿Eliminar este estudiante?')">
                                @csrf @method('DELETE')
                                <button type="submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6">No hay estudiantes registrados.</td></tr>
                @endforelse
            </tbody>
        </table>

        {{ $estudiantes->links() }}
    </div>
@endsection
