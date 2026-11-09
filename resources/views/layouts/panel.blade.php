@php
    $rol = strtolower(trim(auth()->user()->rol));
    $esAdmin = in_array($rol, ['admin', 'administrador']);
    $esDocente = $rol === 'docente';
    $esEstudiante = $rol === 'estudiante';
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo', 'Panel') - Asistencia & Notas</title>
    <link rel="stylesheet" href="{{ asset('css/panel.css') }}">
</head>
<body>
    <aside class="sidebar">

        <div class="marca">🎓 Asistencia & Notas</div>

        <nav>
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'activo' : '' }}">🏠 Inicio</a>

            {{-- ADMINISTRADOR --}}
            @if ($esAdmin)
                <div class="titulo-menu">Administración</div>
                <a href="{{ route('usuarios.index') }}" class="{{ request()->routeIs('usuarios.*') ? 'activo' : '' }}">👥 Usuarios</a>
                <a href="{{ route('docentes.index') }}" class="{{ request()->routeIs('docentes.*') ? 'activo' : '' }}">👨‍🏫 Docentes</a>

                <div class="titulo-menu">Gestión académica</div>
                <a href="{{ route('periodos.index') }}" class="{{ request()->routeIs('periodos.*') ? 'activo' : '' }}">📅 Periodos</a>
                <a href="{{ route('cursos.index') }}" class="{{ request()->routeIs('cursos.*') ? 'activo' : '' }}">📚 Cursos</a>
                <a href="{{ route('notas.index') }}">📒 Notas</a>
                <a href="{{ route('secciones.index') }}" class="{{ request()->routeIs('secciones.*') ? 'activo' : '' }}">🏫 Secciones</a>
                <a href="{{ route('estudiantes.index') }}" class="{{ request()->routeIs('estudiantes.*') ? 'activo' : '' }}">🧑‍🎓 Estudiantes</a>
                <a href="{{ route('matriculas.index') }}" class="{{ request()->routeIs('matriculas.*') ? 'activo' : '' }}">📝 Matrículas</a>
                <a href="{{ route('asignaciones.index') }}" class="{{ request()->routeIs('asignaciones.*') ? 'activo' : '' }}">👩‍🏫 Asignaciones</a>

                <div class="titulo-menu">Asistencia</div>
                <a href="{{ route('asistencia.create') }}" class="{{ request()->routeIs('asistencia.*') ? 'activo' : '' }}">✅ Tomar asistencia</a>
                <a href="{{ route('historial.index') }}" class="{{ request()->routeIs('historial.*') ? 'activo' : '' }}">📊 Historial</a>
            @endif

            {{-- DOCENTE --}}
            @if ($esDocente)
                <div class="titulo-menu">Mi trabajo</div>
                <a href="{{ route('cursos.index') }}" class="{{ request()->routeIs('cursos.*') ? 'activo' : '' }}">📚 Cursos</a>
                <a href="{{ route('estudiantes.index') }}" class="{{ request()->routeIs('estudiantes.*') ? 'activo' : '' }}">🧑‍🎓 Estudiantes</a>
                <a href="{{ route('matriculas.index') }}" class="{{ request()->routeIs('matriculas.*') ? 'activo' : '' }}">📝 Matrículas</a>
                <a href="{{ route('notas.index') }}">📝 Notas</a>

                <div class="titulo-menu">Asistencia</div>
                <a href="{{ route('asistencia.create') }}" class="{{ request()->routeIs('asistencia.*') ? 'activo' : '' }}">✅ Tomar asistencia</a>
                <a href="{{ route('historial.index') }}" class="{{ request()->routeIs('historial.*') ? 'activo' : '' }}">📊 Historial</a>
            @endif

            {{-- ESTUDIANTE --}}
            @if ($esEstudiante)
                <div class="titulo-menu">Mi información</div>
                <a href="{{ route('estudiante.cursos') }}" class="{{ request()->routeIs('estudiante.cursos') ? 'activo' : '' }}">📚 Mis cursos</a>
                <a href="{{ route('estudiante.notas') }}" class="{{ request()->routeIs('estudiante.notas') ? 'activo' : '' }}"> 📒 Notas</a>
                   <a href="{{ route('historial.index') }}" class="{{ request()->routeIs('historial.*') ? 'activo' : '' }}">📊 Historial</a>
            @endif
        </nav>

        <div class="usuario">
            <div class="usuario-datos">
                <div class="usuario-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div class="usuario-texto">
                    <strong>{{ auth()->user()->name }}</strong>
                    <small>{{ ucfirst(auth()->user()->rol) }}</small>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-salir">🚪 Cerrar sesión</button>
            </form>
        </div>
    </aside>

    <main class="contenido">

        {{-- Barra superior con el icono de perfil --}}
        <div class="topbar">
            <div class="perfil-menu" id="perfilMenu">
                <button type="button" class="perfil-btn" onclick="togglePerfil()" aria-label="Mi perfil">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </button>

                <div class="perfil-dropdown" id="perfilDropdown">
                    <div class="perfil-info">
                        <div class="perfil-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                        <div>
                            <strong>{{ auth()->user()->name }}</strong>
                            <small>{{ auth()->user()->email }}</small>
                            <span class="perfil-rol">{{ ucfirst(auth()->user()->rol) }}</span>
                        </div>
                    </div>

                    <a href="{{ route('dashboard') }}">👤 Mi perfil</a>

                    {{-- Lleva al dashboard con el formulario de eliminar abierto --}}
                    <a href="{{ route('dashboard') }}#eliminar-cuenta" class="perfil-peligro">🗑️ Eliminar cuenta</a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">🚪 Cerrar sesión</button>
                    </form>
                </div>
            </div>
        </div>

        @if (session('ok'))
            <div class="alerta alerta-ok">{{ session('ok') }}</div>
        @endif
        @if ($errors->has('general'))
            <div class="alerta alerta-error">{{ $errors->first('general') }}</div>
        @endif

        @yield('contenido')
    </main>

    <script>
        function togglePerfil() {
            document.getElementById('perfilDropdown').classList.toggle('abierto');
        }

        // Cierra el menú al hacer clic fuera
        document.addEventListener('click', function (e) {
            const menu = document.getElementById('perfilMenu');
            if (menu && !menu.contains(e.target)) {
                document.getElementById('perfilDropdown').classList.remove('abierto');
            }
        });
    </script>

</body>

</html>


