<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Inicio
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Bienvenida --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <p>Bienvenido, <strong>{{ auth()->user()->name }}</strong>.</p>
            </div>

            {{-- Tarjeta de Mi perfil --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h2 class="text-lg font-bold">👤 Mi perfil</h2>
                <p class="text-gray-600">Consulta y actualiza la información de tu cuenta.</p>

                <ul class="mt-3 text-gray-700">
                    <li><strong>Nombre:</strong> {{ auth()->user()->name }}</li>
                    <li><strong>Correo:</strong> {{ auth()->user()->email }}</li>
                    <li><strong>Rol:</strong> {{ auth()->user()->rol }}</li>
                </ul>

                {{-- Botones que despliegan los formularios --}}
                <div class="mt-4 flex flex-wrap gap-4">
                    <button type="button" id="btnPerfil" onclick="toggleForm('formPerfil')"
                            class="text-blue-600 underline font-medium">
                        ✏️ Editar mi perfil
                    </button>
                    <button type="button" id="btnPassword" onclick="toggleForm('formPassword')"
                            class="text-blue-600 underline font-medium">
                        🔑 Cambiar contraseña
                    </button>
                    <button type="button" id="btnEliminar" onclick="toggleForm('formEliminar')"
                            class="text-red-600 underline font-medium">
                        🗑️ Eliminar cuenta
                    </button>
                </div>

                {{-- FORMULARIO 1: Datos personales --}}
                <div id="formPerfil"
                     class="{{ $errors->has('name') || $errors->has('email') ? '' : 'hidden' }} mt-6 pt-6 border-t border-gray-200">
                    @include('profile.partials.update-profile-information-form')
                </div>

                {{-- FORMULARIO 2: Contraseña --}}
                <div id="formPassword"
                     class="{{ $errors->updatePassword->isNotEmpty() ? '' : 'hidden' }} mt-6 pt-6 border-t border-gray-200">
                    @include('profile.partials.update-password-form')
                </div>

                {{-- FORMULARIO 3: Eliminar cuenta --}}
                <div id="formEliminar"
                     class="{{ $errors->userDeletion->isNotEmpty() ? '' : 'hidden' }} mt-6 pt-6 border-t border-gray-200">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>

    <script>
        const formIds = ['formPerfil', 'formPassword', 'formEliminar'];

        function toggleForm(id) {
            formIds.forEach(function (formId) {
                const el = document.getElementById(formId);

                if (formId === id) {
                    // Si ya está abierto, lo cierra; si está cerrado, lo abre
                    el.classList.toggle('hidden');
                } else {
                    // Los demás siempre se ocultan
                    el.classList.add('hidden');
                }
            });
        }

        // Si llegas desde el menú del icono de perfil con #eliminar-cuenta
        if (window.location.hash === '#eliminar-cuenta') {
            toggleForm('formEliminar');
            document.getElementById('formEliminar').scrollIntoView({ behavior: 'smooth' });
        }
    </script>
</x-app-layout>
