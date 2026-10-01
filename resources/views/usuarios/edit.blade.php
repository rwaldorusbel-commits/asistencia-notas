<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar usuario</h2>
    </x-slot>

    <div class="py-8 max-w-xl mx-auto sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('usuarios.update', $usuario) }}" class="bg-white shadow rounded p-6 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block mb-1">Nombre</label>
                <input type="text" name="name" value="{{ old('name', $usuario->name) }}" class="w-full border-gray-300 rounded">
                @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $usuario->email) }}" class="w-full border-gray-300 rounded">
                @error('email') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">Rol</label>
                <select name="rol" class="w-full border-gray-300 rounded">
                    @foreach ($roles as $rol)
                        <option value="{{ $rol }}" @selected(old('rol', $usuario->rol) === $rol)>{{ ucfirst($rol) }}</option>
                    @endforeach
                </select>
                @error('rol') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">Nueva contraseña (opcional)</label>
                <input type="password" name="password" class="w-full border-gray-300 rounded">
                @error('password') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">Confirmar contraseña</label>
                <input type="password" name="password_confirmation" class="w-full border-gray-300 rounded">
            </div>

            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Actualizar</button>
                <a href="{{ route('usuarios.index') }}" class="px-4 py-2 bg-gray-200 rounded">Cancelar</a>
            </div>
        </form>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Editar usuario</h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto px-4">
        <form method="POST" action="{{ route('usuarios.update', $usuario) }}" class="bg-white p-6 shadow rounded-lg">
            @csrf
            @method('PUT')
            @include('usuarios._form')
            <div class="flex gap-2">
                <button class="px-4 py-2 bg-indigo-600 text-white rounded-md">Actualizar</button>
                <a href="{{ route('usuarios.index') }}" class="px-4 py-2 bg-gray-200 rounded-md">Cancelar</a>
            </div>
        </form>
    </div>
</x-app-layout>
