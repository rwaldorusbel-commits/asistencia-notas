<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ui.nav_home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Bienvenida --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <p>{!! __('ui.welcome_user', ['name' => '<strong>' . e(auth()->user()->name) . '</strong>']) !!}</p>
            </div>

            {{-- Tarjeta de Mi perfil --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h2 class="text-lg font-bold">👤 {{ __('ui.my_profile') }}</h2>
                <p class="text-gray-600">{{ __('ui.profile_desc') }}</p>

                <ul class="mt-3 text-gray-700">
                    <li><strong>{{ __('ui.name') }}:</strong> {{ auth()->user()->name }}</li>
                    <li><strong>{{ __('ui.email') }}:</strong> {{ auth()->user()->email }}</li>
                    <li><strong>{{ __('ui.role') }}:</strong> {{ __('ui.role_' . strtolower(auth()->user()->rol)) }}</li>
                </ul>

                {{-- Botones que despliegan los formularios --}}
                <div class="mt-4 flex flex-wrap gap-4">
                    <button type="button" id="btnPerfil" onclick="toggleForm('formPerfil')"
                            class="text-blue-600 underline font-medium">
                        ✏️ {{ __('ui.edit_profile') }}
                    </button>
                    <button type="button" id="btnPassword" onclick="toggleForm('formPassword')"
                            class="text-blue-600 underline font-medium">
                        🔑 {{ __('ui.change_password') }}
                    </button>
                    <button type="button" id="btnEliminar" onclick="toggleForm('formEliminar')"
                            class="text-red-600 underline font-medium">
                        🗑️ {{ __('ui.delete_acc') }}
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
                    el.classList.toggle('hidden');
                } else {
                    el.classList.add('hidden');
                }
            });
        }

        if (window.location.hash === '#eliminar-cuenta') {
            toggleForm('formEliminar');
            document.getElementById('formEliminar').scrollIntoView({ behavior: 'smooth' });
        }
    </script>
</x-app-layout>
