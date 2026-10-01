@extends('layouts.panel')
@section('titulo', 'Docentes')

@section('contenido')
    <div class="encabezado">
        <h1>👨‍🏫 Docentes</h1>
        <a href="{{ route('docentes.create') }}" class="btn">+ Nuevo docente</a>
    </div>

    <div class="tarjeta">
        <form method="GET" style="margin-bottom:12px">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar por nombre o correo">
            <button type="submit">Buscar</button>
        </form>

        <div class="tabla-wrap">
            <table>
                <thead>
                    <tr><th>Nombre</th><th>Correo</th><th>Estado</th><th>Acciones</th></tr>
                </thead>
                <tbody>
                @forelse ($docentes as $d)
                    <tr>
                        <td>{{ $d->name }}</td>
                        <td>{{ $d->email }}</td>
                        <td>
                            <span class="badge {{ $d->activo ? 'badge-verde' : 'badge-rojo' }}">
                                {{ $d->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td>
                            <div class="acciones">
                                <a href="{{ route('docentes.edit', $d) }}" class="btn btn-chico">Editar</a>
                                <form method="POST" action="{{ route('docentes.destroy', $d) }}"
                                      onsubmit="return confirm('¿Eliminar este docente?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-chico btn-rojo">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" style="text-align:center;color:#94a3b8">Aún no hay docentes.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="paginacion">{{ $docentes->links() }}</div>
    </div>
@endsection
