@extends('layouts.panel')
@section('titulo', 'Notas')

@section('contenido')
    <div class="encabezado">
        <h1>📝 Notas</h1>
    </div>

    <div class="tarjeta">
        <p style="margin-bottom:12px;color:#6b7280">Elige el curso y la sección donde vas a registrar notas.</p>

        <table>
            <thead>
                <tr>
                    <th>Curso</th><th>Sección</th><th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($asignaciones as $a)
                    <tr>
                        <td>{{ $a->curso->nombre ?? 'Curso' }}</td>
                        <td>{{ $a->seccion->nombre ?? 'Sección' }}</td>
                        <td><a href="{{ route('notas.show', $a) }}">Registrar notas</a></td>
                    </tr>
                @empty
                    <tr><td colspan="3">No hay asignaciones registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
