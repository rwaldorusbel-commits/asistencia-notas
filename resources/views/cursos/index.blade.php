@extends('layouts.panel')
@section('titulo', 'Cursos')

@section('contenido')
    <div class="encabezado">
        <h1>📚 Cursos</h1>
        <a href="{{ route('cursos.create') }}" class="btn">+ Nuevo curso</a>
    </div>

    <div class="tarjeta">
        <div class="tabla-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($cursos as $c)
                    <tr>
                        <td>{{ $c->codigo }}</td>
                        <td>{{ $c->nombre }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($c->descripcion, 60) }}</td>
                        <td>
                            <span class="badge {{ $c->activo ? 'badge-verde' : 'badge-rojo' }}">
                                {{ $c->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td>
                            <div class="acciones">
                                <a href="{{ route('cursos.edit', $c) }}" class="btn btn-chico">Editar</a>
                                <form method="POST" action="{{ route('cursos.destroy', $c) }}"
                                      onsubmit="return confirm('¿Eliminar este curso?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-chico btn-rojo">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" style="text-align:center;color:#94a3b8">Aún no hay cursos registrados.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="paginacion">{{ $cursos->links() }}</div>
    </div>
@endsection
