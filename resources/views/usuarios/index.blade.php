<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Usuarios</h2>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto sm:px-6 lg:px-8">

        @if (session('ok'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('ok') }}</div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ $errors->first() }}</div>
        @endif

        <div class="flex justify-between mb-4">
            <form method="GET" action="{{ route('usuarios.index') }}">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar..."
                       class="border-gray-300 rounded">
                <button type="submit" class="px-3 py-2 bg-gray-800 text-white rounded">Buscar</button>
            </form>

            <a href="{{ route('usuarios.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">
                Nuevo usuario
            </a>
        </div>

        <div class="bg-white shadow rounded overflow-x-auto">
            <table class="min-w-full text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3">Nombre</th>
                        <th class="p-3">Email</th>
                        <th class="p-3">Rol</th>
                        <th class="p-3">Estado</th>
                        <th class="p-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $u)
                        <tr class="border-t">
                            <td class="p-3">{{ $u->name }}</td>
                            <td class="p-3">{{ $u->email }}</td>
                            <td class="p-3">{{ ucfirst($u->rol) }}</td>
                            <td class="p-3">{{ $u->activo ? 'Activo' : 'Inactivo' }}</td>
                            <td class="p-3 flex gap-2">
                                <a href="{{ route('usuarios.edit', $u) }}" class="text-blue-600">Editar</a>

                                @if ($u->activo)
                                    <form method="POST" action="{{ route('usuarios.destroy', $u) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600">Desactivar</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('usuarios.activar', $u) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-green-600">Activar</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $usuarios->links() }}</div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Usuarios</h2>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto px-4">
        @if (session('ok'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('ok') }}</div>
        @endif
        @error('usuario')
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ $message }}</div>
        @enderror

        <div class="flex justify-between mb-4">
            <form method="GET" class="flex gap-2">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar..."
                       class="rounded-md border-gray-300">
                <button class="px-3 py-2 bg-gray-200 rounded-md">Buscar</button>
            </form>
            <a href="{{ route('usuarios.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md">
                Nuevo usuario
            </a>
        </div>

        <div class="bg-white shadow rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-left">
                    <tr>
                        <th class="p-3">Nombre</th>
                        <th class="p-3">Correo</th>
                        <th class="p-3">Rol</th>
                        <th class="p-3">Estado</th>
                        <th class="p-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($usuarios as $u)
                    <tr class="border-t">
                        <td class="p-3">{{ $u->name }}</td>
                        <td class="p-3">{{ $u->email }}</td>
                        <td class="p-3">{{ ucfirst($u->rol) }}</td>
                        <td class="p-3">
                            @if ($u->activo)
                                <span class="text-green-700">Activo</span>
                            @else
                                <span class="text-red-700">Desactivado</span>
                            @endif
                        </td>
                        <td class="p-3 flex gap-2">
                            <a href="{{ route('usuarios.edit', $u) }}" class="text-indigo-600">Editar</a>

                            @if ($u->activo)
                                <form method="POST" action="{{ route('usuarios.destroy', $u) }}"
                                      onsubmit="return confirm('¿Desactivar este usuario?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600">Desactivar</button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('usuarios.activar', $u) }}">
                                    @csrf @method('PATCH')
                                    <button class="text-green-600">Activar</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $usuarios->links() }}</div>
    </div>
</x-app-layout>
