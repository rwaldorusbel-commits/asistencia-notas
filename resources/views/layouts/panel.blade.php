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

            @if (in_array(strtolower(trim(auth()->user()->rol)), ['admin', 'administrador']))
                <div class="titulo-menu">Administración</div>
                <a href="{{ route('usuarios.index') }}" class="{{ request()->routeIs('usuarios.*') ? 'activo' : '' }}">👥 Usuarios</a>

                <div class="titulo-menu">Gestión académica</div>
                <a href="{{ route('periodos.index') }}" class="{{ request()->routeIs('periodos.*') ? 'activo' : '' }}">📅 Periodos</a>
                <a href="{{ route('cursos.index') }}" class="{{ request()->routeIs('cursos.*') ? 'activo' : '' }}">📚 Cursos</a>
                <a href="{{ route('secciones.index') }}" class="{{ request()->routeIs('secciones.*') ? 'activo' : '' }}">🏫 Secciones</a>
                <a href="{{ route('estudiantes.index') }}" class="{{ request()->routeIs('estudiantes.*') ? 'activo' : '' }}">🧑‍🎓 Estudiantes</a>
                 <a href="{{ route('matriculas.index') }}" class="{{ request()->routeIs('matriculas.*') ? 'activo' : '' }}">📝 Matrículas</a>
                  <a href="{{ route('asignaciones.index') }}">👩‍🏫 Asignaciones</a>
<a href="{{ route('docentes.index') }}">👨‍🏫 Docentes</a>
<a href="{{ route('asistencia.create') }}">✅ Tomar asistencia</a>
<a href="{{ route('historial.index') }}">Historial</a>

                {{-- Asignaciones se agregan aquí después --}}
            @endif
        </nav>

        <div class="usuario">
            {{ auth()->user()->name }}<br>
            <small>{{ ucfirst(auth()->user()->rol) }}</small>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Cerrar sesión</button>
            </form>
        </div>
    </aside>

    <main class="contenido">
        @if (session('ok'))
            <div class="alerta alerta-ok">{{ session('ok') }}</div>
        @endif
        @if ($errors->has('general'))
            <div class="alerta alerta-error">{{ $errors->first('general') }}</div>
        @endif

        @yield('contenido')
    </main>
</body>
</html>
