@extends('layouts.panel')
@section('titulo', 'Secciones')

@section('contenido')
    <div class="encabezado">
        <h1>🏫 Grados y secciones</h1>
        <a href="{{ route('secciones.create') }}" class="btn">+ Nueva sección</a>
    </div>

    <div class="tarjeta">
        <div class="tabla-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Periodo</th>
                        <th>Grado</th>
                        <th>Sección</th>
                        <th>Capacidad</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($secciones as $s)
                    <tr>
                        <td>{{ $s->periodo->nombre }}</td>
                     <td>{{ $s->grado->nombre ?? '—' }}</td>
                        <td>{{ $s->nombre }}</td>
                        <td>{{ $s->capacidad }}</td>
                        <td>
                            <span class="badge {{ $s->activo ? 'badge-verde' : 'badge-rojo' }}">
                                {{ $s->activo ? 'Activa' : 'Inactiva' }}
                            </span>
                        </td>
                        <td>
                            <div class="acciones">
                                <a href="{{ route('secciones.edit', $s) }}" class="btn btn-chico">Editar</a>
                                <form method="POST" action="{{ route('secciones.destroy', $s) }}"
                                      onsubmit="return confirm('¿Eliminar esta sección?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-chico btn-rojo">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center;color:#94a3b8">Aún no hay secciones registradas.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="paginacion">{{ $secciones->links() }}</div>
    </div>
@endsection
