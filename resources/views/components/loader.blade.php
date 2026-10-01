<div x-data="{ cargando: true }"
     x-init="window.addEventListener('load', () => setTimeout(() => cargando = false, 600))"
     @mostrar-carga.window="cargando = true"
     x-show="cargando"
     x-transition.opacity.duration.500ms
     x-cloak
     class="fixed inset-0 z-[9999] flex flex-col items-center justify-center
            bg-gradient-to-br from-indigo-900 via-purple-900 to-slate-900 text-white">

    {{-- Círculos decorativos --}}
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-indigo-500/30 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 right-0 w-[28rem] h-[28rem] bg-purple-500/30 rounded-full blur-3xl"></div>

    <div class="relative flex flex-col items-center">
        {{-- Anillo giratorio con el ícono --}}
        <div class="relative w-24 h-24">
            <div class="absolute inset-0 rounded-full border-4 border-white/20"></div>
            <div class="absolute inset-0 rounded-full border-4 border-transparent border-t-sky-300 animate-spin"></div>
            <div class="absolute inset-0 flex items-center justify-center text-4xl animate-pulse">🎓</div>
        </div>

        <h2 class="mt-6 text-xl font-semibold">Asistencia & Notas</h2>
        <p class="mt-1 text-sm text-indigo-200">Cargando...</p>

        {{-- Barra de progreso --}}
        <div class="mt-5 w-48 h-1.5 bg-white/20 rounded-full overflow-hidden">
            <div class="h-full w-1/2 bg-gradient-to-r from-sky-300 to-pink-300 rounded-full animate-[carga_1.2s_ease-in-out_infinite]"></div>
        </div>
    </div>
</div>
