@extends('layouts.panel')
@section('titulo', 'Periodos')

@section('contenido')
    <div class="encabezado">
        <h1>📅 Periodos</h1>
        <a href="{{ route('periodos.create') }}" class="btn">+ Nuevo periodo</a>
    </div>

    <div class="tarjeta">
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Año</th>
                    <th>Tipo</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($periodos as $p)
                    <tr>
                        <td>{{ $p->nombre }}</td>
                        <td>{{ $p->anio }}</td>
                        <td>{{ ucfirst($p->tipo) }}</td>
                        <td>{{ $p->fecha_inicio }}</td>
                        <td>{{ $p->fecha_fin }}</td>
                        <td>{{ $p->activo ? 'Activo' : 'Inactivo' }}</td>
                        <td>
                            <a href="{{ route('periodos.edit', $p) }}">Editar</a>
                            <form method="POST" action="{{ route('periodos.destroy', $p) }}"
                                  style="display:inline"
                                  onsubmit="return confirm('¿Eliminar este periodo?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7">No hay periodos registrados.</td></tr>
                @endforelse
            </tbody>
        </table>

        {{ $periodos->links() }}
    </div>
@endsection
