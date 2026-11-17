@extends('layouts.panel')
@section('titulo', 'Tomar asistencia')

@section('contenido')
    <div class="encabezado"><h1>Tomar asistencia</h1></div>

    <div class="tarjeta">
        @if (session('status'))
            <p style="color:#16a34a">{{ session('status') }}</p>
        @endif
        @if ($errors->any())
            <p style="color:#dc2626">{{ $errors->first() }}</p>
        @endif

        <form method="GET" style="margin-bottom:12px">
            <select name="asignacion_id" required>
                <option value="">Seleccione curso</option>
                @foreach ($asignaciones as $a)
                    <option value="{{ $a->id }}" {{ $asignacion && $asignacion->id === $a->id ? 'selected' : '' }}>
                        {{ $a->seccion->periodo->nombre ?? '' }} - {{ $a->seccion->grado->nombre ?? '' }}
                        {{ $a->seccion->nombre }} - {{ $a->curso->nombre }}
                    </option>
                @endforeach
            </select>
            <input type="date" name="fecha" value="{{ $fecha }}">
            <button type="submit">Cargar estudiantes</button>
        </form>

        @if ($asignacion)
            <form method="POST" action="{{ route('asistencia.store') }}">
                @csrf
                <input type="hidden" name="asignacion_id" value="{{ $asignacion->id }}">
                <input type="hidden" name="fecha" value="{{ $fecha }}">

                <div class="tabla-wrap">
                    <table>
                        <thead>
                            <tr><th>Estudiante</th><th>Presente</th><th>Tarde</th><th>Falta</th></tr>
                        </thead>
                        <tbody>
                        @forelse ($matriculas as $m)
                            @php $actual = $existentes[$m->id] ?? 'presente'; @endphp
                            <tr>
                                <td>{{ $m->estudiante->apellidos }}, {{ $m->estudiante->nombres }}</td>
                                @foreach (['presente', 'tarde', 'falta'] as $estado)
                                    <td>
                                        <input type="radio" name="estados[{{ $m->id }}]"
                                               value="{{ $estado }}" {{ $actual === $estado ? 'checked' : '' }}>
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr><td colspan="4" style="text-align:center;color:#94a3b8">No hay estudiantes matriculados en esta sección.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <button type="submit" class="btn" style="margin-top:12px">Guardar asistencia</button>
            </form>
        @endif
    </div>

    {{-- Contenedor de notificaciones (uno solo) --}}
    <div id="toast-container" style="position:fixed;top:20px;right:20px;z-index:9999;display:flex;flex-direction:column;gap:10px;"></div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cursoId = {{ $asignacion->curso_id ?? 1 }};

        if (!window.Echo) {
            console.error('Echo no está cargado');
            return;
        }

        window.Echo.channel(`curso.${cursoId}`)
            .listen('AsistenciaTomada', (e) => {
                const toast = document.createElement('div');
                toast.style.cssText = 'background:#4f46e5;color:#fff;padding:15px 25px;border-radius:10px;box-shadow:0 10px 25px rgba(0,0,0,.2);font-size:15px;transition:opacity .5s ease;opacity:0';
                toast.innerHTML = `<strong>🔔 Notificación</strong><br>${e.mensaje}`;

                document.getElementById('toast-container').appendChild(toast);
                setTimeout(() => { toast.style.opacity = '1'; }, 100);
                setTimeout(() => {
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 500);
                }, 4000);
            });
    });
</script>
@endpush

    <script>
        function togglePerfil() {
            document.getElementById('perfilDropdown').classList.toggle('abierto');
        }

        document.addEventListener('click', function (e) {
            const menu = document.getElementById('perfilMenu');
            if (menu && !menu.contains(e.target)) {
                document.getElementById('perfilDropdown').classList.remove('abierto');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
