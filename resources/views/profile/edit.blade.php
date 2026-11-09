<x-layouts.app> {{-- ⚠️ IMPORTANTE: Cambia esto por el nombre de tu layout con el menú morado --}}

    <div class="p-6">
        {{-- Título de la página (igual que en Asignaciones) --}}
        <h1 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
            <i class="fas fa-user-circle mr-2"></i> Mi Perfil
        </h1>

        {{-- Tarjeta blanca al costado --}}
        <div class="bg-white rounded-lg shadow-sm p-6 max-w-3xl">

            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Información Personal</h2>
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="border-t border-gray-200 pt-8">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Cambiar Contraseña</h2>
                @include('profile.partials.update-password-form')
            </div>

        </div>
    </div>

</x-layouts.app>
