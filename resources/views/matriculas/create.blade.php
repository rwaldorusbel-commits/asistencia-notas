<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📝 Nueva matrícula
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <form method="POST" action="{{ route('matriculas.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="estudiante_id" class="block font-medium text-sm text-gray-700">Estudiante</label>
                        <select name="estudiante_id" id="estudiante_id" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Selecciona --</option>
                            @foreach ($estudiantes as $e)
                                <option value="{{ $e->id }}" @selected(old('estudiante_id') == $e->id)>
                                    {{ $e->apellidos }}, {{ $e->nombres }} ({{ $e->codigo }})
                                </option>
                            @endforeach
                        </select>
                        @error('estudiante_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="seccion_id" class="block font-medium text-sm text-gray-700">
                            Sección (el periodo se toma de ella)
                        </label>
                        <select name="seccion_id" id="seccion_id" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Selecciona --</option>
                            @foreach ($secciones as $s)
                                <option value="{{ $s->id }}" @selected(old('seccion_id') == $s->id)>
                                    {{ $s->periodo->nombre ?? '' }} - {{ $s->grado->nombre ?? '' }} {{ $s->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('seccion_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="fecha_matricula" class="block font-medium text-sm text-gray-700">Fecha de matrícula</label>
                        <input type="date" name="fecha_matricula" id="fecha_matricula" required
                               value="{{ old('fecha_matricula', date('Y-m-d')) }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('fecha_matricula') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit"
                                class="px-4 py-2 bg-gray-800 text-white rounded-md text-xs font-semibold uppercase tracking-widest hover:bg-gray-700">
                            Matricular
                        </button>
                        <a href="{{ route('matriculas.index') }}" class="text-sm text-gray-600 underline">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
