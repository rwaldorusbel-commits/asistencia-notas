@php
    $rol = strtolower(trim(auth()->user()->rol));
    $esAdmin = in_array($rol, ['admin', 'administrador']);
    $esDocente = $rol === 'docente';
    $esEstudiante = $rol === 'estudiante';
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo', __('ui.panel')) - {{ __('ui.app_name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/panel.css') }}">

      @vite(['resources/js/app.js'])
</head>
<body>
    <aside class="sidebar">

        <div class="marca">🎓 {{ __('ui.app_name') }}</div>

        <nav>
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'activo' : '' }}">🏠 {{ __('ui.nav_home') }}</a>

            {{-- ADMINISTRADOR --}}
            @if ($esAdmin)
                <div class="titulo-menu">{{ __('ui.nav_administration') }}</div>
                <a href="{{ route('usuarios.index') }}" class="{{ request()->routeIs('usuarios.*') ? 'activo' : '' }}">👥 {{ __('ui.nav_users') }}</a>
                <a href="{{ route('docentes.index') }}" class="{{ request()->routeIs('docentes.*') ? 'activo' : '' }}">👨‍🏫 {{ __('ui.nav_teachers') }}</a>

                <div class="titulo-menu">{{ __('ui.nav_academic') }}</div>
                <a href="{{ route('periodos.index') }}" class="{{ request()->routeIs('periodos.*') ? 'activo' : '' }}">📅 {{ __('ui.nav_periods') }}</a>
                <a href="{{ route('cursos.index') }}" class="{{ request()->routeIs('cursos.*') ? 'activo' : '' }}">📚 {{ __('ui.nav_courses') }}</a>
                <a href="{{ route('notas.index') }}">📒 {{ __('ui.nav_grades') }}</a>
                <a href="{{ route('secciones.index') }}" class="{{ request()->routeIs('secciones.*') ? 'activo' : '' }}">🏫 {{ __('ui.nav_sections') }}</a>
                <a href="{{ route('estudiantes.index') }}" class="{{ request()->routeIs('estudiantes.*') ? 'activo' : '' }}">🧑‍🎓 {{ __('ui.nav_students') }}</a>
                <a href="{{ route('matriculas.index') }}" class="{{ request()->routeIs('matriculas.*') ? 'activo' : '' }}">📝 {{ __('ui.nav_enrollments') }}</a>
                <a href="{{ route('asignaciones.index') }}" class="{{ request()->routeIs('asignaciones.*') ? 'activo' : '' }}">👩‍🏫 {{ __('ui.nav_assignments') }}</a>

                <div class="titulo-menu">{{ __('ui.nav_attendance') }}</div>
                <a href="{{ route('asistencia.create') }}" class="{{ request()->routeIs('asistencia.*') ? 'activo' : '' }}">✅ {{ __('ui.nav_take_attendance') }}</a>
                <a href="{{ route('historial.index') }}" class="{{ request()->routeIs('historial.*') ? 'activo' : '' }}">📊 {{ __('ui.nav_history') }}</a>
            @endif

            {{-- DOCENTE --}}
            @if ($esDocente)
                <div class="titulo-menu">{{ __('ui.nav_my_work') }}</div>
                <a href="{{ route('cursos.index') }}" class="{{ request()->routeIs('cursos.*') ? 'activo' : '' }}">📚 {{ __('ui.nav_courses') }}</a>
                <a href="{{ route('estudiantes.index') }}" class="{{ request()->routeIs('estudiantes.*') ? 'activo' : '' }}">🧑‍🎓 {{ __('ui.nav_students') }}</a>
                <a href="{{ route('matriculas.index') }}" class="{{ request()->routeIs('matriculas.*') ? 'activo' : '' }}">📝 {{ __('ui.nav_enrollments') }}</a>
                <a href="{{ route('notas.index') }}">📝 {{ __('ui.nav_grades') }}</a>

                <div class="titulo-menu">{{ __('ui.nav_attendance') }}</div>
                <a href="{{ route('asistencia.create') }}" class="{{ request()->routeIs('asistencia.*') ? 'activo' : '' }}">✅ {{ __('ui.nav_take_attendance') }}</a>
                <a href="{{ route('historial.index') }}" class="{{ request()->routeIs('historial.*') ? 'activo' : '' }}">📊 {{ __('ui.nav_history') }}</a>
            @endif

            {{-- ESTUDIANTE --}}
            @if ($esEstudiante)
                <div class="titulo-menu">{{ __('ui.nav_my_info') }}</div>
                <a href="{{ route('estudiante.cursos') }}" class="{{ request()->routeIs('estudiante.cursos') ? 'activo' : '' }}">📚 {{ __('ui.nav_my_courses') }}</a>
                <a href="{{ route('estudiante.notas') }}" class="{{ request()->routeIs('estudiante.notas') ? 'activo' : '' }}"> 📒 {{ __('ui.nav_grades') }}</a>
                <a href="{{ route('historial.index') }}" class="{{ request()->routeIs('historial.*') ? 'activo' : '' }}">📊 {{ __('ui.nav_history') }}</a>
            @endif
        </nav>

        <div class="usuario">
            <div class="usuario-datos">
                <div class="usuario-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div class="usuario-texto">
                    <strong>{{ auth()->user()->name }}</strong>
                    <small>{{ __('ui.role_' . strtolower(trim(auth()->user()->rol))) }}</small>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-salir">🚪 {{ __('ui.logout') }}</button>
            </form>
        </div>
    </aside>

    <main class="contenido">

        {{-- Barra superior con el icono de perfil --}}
        <div class="topbar">
            <div class="perfil-menu" id="perfilMenu">
                <button type="button" class="perfil-btn" onclick="togglePerfil()" aria-label="{{ __('ui.my_profile') }}">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </button>

                <div class="perfil-dropdown" id="perfilDropdown">
                    <div class="perfil-info">
                        <div class="perfil-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                        <div>
                            <strong>{{ auth()->user()->name }}</strong>
                            <small>{{ auth()->user()->email }}</small>
                            <span class="perfil-rol">{{ __('ui.role_' . strtolower(trim(auth()->user()->rol))) }}</span>
                        </div>
                    </div>

                    <a href="{{ route('dashboard') }}">👤 {{ __('ui.my_profile') }}</a>

                    {{-- Lleva al dashboard con el formulario de eliminar abierto --}}
                    <a href="{{ route('dashboard') }}#eliminar-cuenta" class="perfil-peligro">🗑️ {{ __('ui.delete_acc') }}</a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">🚪 {{ __('ui.logout') }}</button>
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
