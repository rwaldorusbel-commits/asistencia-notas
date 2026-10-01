@php $u = $usuario ?? null; @endphp

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Nombre</label>
    <input type="text" name="name" value="{{ old('name', $u?->name) }}"
           class="mt-1 w-full rounded-md border-gray-300 shadow-sm" required>
    @error('name') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Correo</label>
    <input type="email" name="email" value="{{ old('email', $u?->email) }}"
           class="mt-1 w-full rounded-md border-gray-300 shadow-sm" required>
    @error('email') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Rol</label>
    <select name="rol" class="mt-1 w-full rounded-md border-gray-300 shadow-sm" required>
        @foreach ($roles as $rol)
            <option value="{{ $rol }}" @selected(old('rol', $u?->rol) === $rol)>
                {{ ucfirst($rol) }}
            </option>
        @endforeach
    </select>
    @error('rol') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">
        Contraseña @if($u) <span class="text-gray-400">(dejar vacío para no cambiarla)</span> @endif
    </label>
    <input type="password" name="password"
           class="mt-1 w-full rounded-md border-gray-300 shadow-sm" {{ $u ? '' : 'required' }}>
    @error('password') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Confirmar contraseña</label>
    <input type="password" name="password_confirmation"
           class="mt-1 w-full rounded-md border-gray-300 shadow-sm" {{ $u ? '' : 'required' }}>
</div>
