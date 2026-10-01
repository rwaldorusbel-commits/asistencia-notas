<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Asistencia y Notas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-900 via-purple-900 to-slate-900 text-white antialiased relative overflow-hidden">

    {{-- Círculos decorativos de fondo --}}
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-indigo-500/30 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 right-0 w-[28rem] h-[28rem] bg-purple-500/30 rounded-full blur-3xl"></div>
    <div class="absolute top-1/2 left-1/2 w-72 h-72 bg-sky-400/20 rounded-full blur-3xl"></div>

    <div class="relative z-10 max-w-6xl mx-auto px-6">

        {{-- Barra superior --}}
        <header class="flex items-center justify-between py-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white/15 backdrop-blur flex items-center justify-center text-xl">🎓</div>
                <span class="font-semibold text-lg">Asistencia & Notas</span>
            </div>

            @if (Route::has('login'))
                <nav>
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="px-5 py-2 rounded-lg bg-white text-indigo-900 font-medium hover:bg-indigo-100 transition">
                            Ir al panel
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="px-5 py-2 rounded-lg bg-white text-indigo-900 font-medium hover:bg-indigo-100 transition">
                            Iniciar sesión
                        </a>
                    @endauth
                </nav>
            @endif
        </header>

        {{-- Sección principal --}}
        <main class="py-16 md:py-24 text-center">
            <span class="inline-block px-4 py-1 mb-6 rounded-full bg-white/10 border border-white/20 text-sm">
                Gestión académica en línea
            </span>

            <h1 class="text-4xl md:text-6xl font-extrabold leading-tight">
                Controla la <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-300 to-pink-300">asistencia</span><br>
                y las <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-300 to-pink-300">notas</span> de tus estudiantes
            </h1>

            <p class="mt-6 max-w-2xl mx-auto text-lg text-indigo-100">
                Registra asistencia desde el celular, calcula promedios automáticamente
                y genera reportes en PDF y Excel en segundos.
            </p>

            <div class="mt-10 flex flex-wrap justify-center gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="px-8 py-3 rounded-xl bg-gradient-to-r from-sky-400 to-indigo-500 font-semibold shadow-lg hover:scale-105 transition">
                        Entrar al sistema
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="px-8 py-3 rounded-xl bg-gradient-to-r from-sky-400 to-indigo-500 font-semibold shadow-lg hover:scale-105 transition">
                        Ingresar
                    </a>
                @endauth
            </div>
        </main>

        {{-- Tarjetas de funciones --}}
        <section class="grid gap-6 md:grid-cols-3 pb-20">
            <div class="p-6 rounded-2xl bg-white/10 backdrop-blur border border-white/20 hover:bg-white/15 transition">
                <div class="text-3xl mb-3">✅</div>
                <h3 class="font-semibold text-lg">Asistencia diaria</h3>
                <p class="mt-2 text-sm text-indigo-100">Presente, tarde, falta o justificado, por curso y sección.</p>
            </div>

            <div class="p-6 rounded-2xl bg-white/10 backdrop-blur border border-white/20 hover:bg-white/15 transition">
                <div class="text-3xl mb-3">📝</div>
                <h3 class="font-semibold text-lg">Notas y promedios</h3>
                <p class="mt-2 text-sm text-indigo-100">Criterios con peso porcentual y estado aprobado o desaprobado automático.</p>
            </div>

            <div class="p-6 rounded-2xl bg-white/10 backdrop-blur border border-white/20 hover:bg-white/15 transition">
                <div class="text-3xl mb-3">📊</div>
                <h3 class="font-semibold text-lg">Reportes</h3>
                <p class="mt-2 text-sm text-indigo-100">Libretas, actas y reportes de asistencia en PDF y Excel.</p>
            </div>
        </section>

        <footer class="pb-8 text-center text-sm text-indigo-200">
            © {{ date('Y') }} Sistema de Asistencia y Notas
        </footer>
    </div>
</body>
</html>
