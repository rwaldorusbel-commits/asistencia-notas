<x-app-layout>
    <div class="max-w-5xl mx-auto p-6 space-y-6">
        <a href="{{ route('notas.index') }}" class="text-indigo-600 text-sm">← Volver</a>
        <h1 class="text-2xl font-bold">
            {{ $asignacion->curso->nombre ?? 'Curso' }} · {{ $asignacion->seccion->nombre ?? '' }}
        </h1>

        @if (session('message'))
            <div class="bg-green-50 text-green-700 border border-green-200 rounded-lg p-3">{{ session('message') }}</div>
        @endif
        @if ($errors->any())
            <div class="bg-red-50 text-red-700 border border-red-200 rounded-lg p-3">{{ $errors->first() }}</div>
        @endif

        {{-- Registrar una nota para todos --}}
        <form method="POST" action="{{ route('notas.store', $asignacion) }}" class="bg-white rounded-xl shadow p-5">
            @csrf
            <h2 class="font-semibold mb-4">Nueva evaluación</h2>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-5">
                <div>
                    <label class="text-sm font-semibold">Descripción</label>
                    <input name="descripcion" value="{{ old('descripcion') }}" placeholder="Ej: Práctica 1"
                           class="w-full border rounded-lg p-2" required>
                </div>
                <div>
                    <label class="text-sm font-semibold">Peso</label>
                    <input name="peso" type="number" step="0.01" value="{{ old('peso', 1) }}"
                           class="w-full border rounded-lg p-2">
                </div>
                <div>
                    <label class="text-sm font-semibold">Fecha</label>
                    <input name="fecha" type="date" value="{{ old('fecha', now()->toDateString()) }}"
                           class="w-full border rounded-lg p-2" required>
                </div>
            </div>

            <table class="w-full text-sm mb-5">
                <thead>
                    <tr class="text-left text-gray-500 border-b">
                        <th class="py-2">Estudiante</th>
                        <th class="py-2 w-32">Nota (0-20)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($matriculas as $m)
                        <tr class="border-b">
                            <td class="py-2">
                                {{ $m->estudiante->nombres ?? $m->estudiante->nombre ?? 'Estudiante #'.$m->estudiante_id }}
                                {{ $m->estudiante->apellidos ?? '' }}
                            </td>
                            <td class="py-2">
                                <input name="valores[{{ $m->id }}]" type="number" step="0.01" min="0" max="20"
                                       value="{{ old('valores.'.$m->id) }}" class="w-full border rounded-lg p-2">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2 rounded-lg">
                Guardar notas
            </button>
        </form>

        {{-- Notas ya registradas --}}
        <div class="bg-white rounded-xl shadow p-5">
            <h2 class="font-semibold mb-4">Notas registradas</h2>

            @forelse ($matriculas as $m)
                @php
                    $lista = $notas->get($m->id, collect());
                    $pesoTotal = $lista->sum('peso');
                    $promedio = $pesoTotal > 0 ? $lista->sum(fn ($n) => $n->valor * $n->peso) / $pesoTotal : null;
                @endphp
                <div class="border-b py-3">
                    <div class="flex justify-between">
                        <strong>{{ $m->estudiante->nombres ?? $m->estudiante->nombre ?? 'Estudiante' }} {{ $m->estudiante->apellidos ?? '' }}</strong>
                        <span class="text-sm text-gray-500">
                            Promedio: {{ $promedio !== null ? number_format($promedio, 2) : '—' }}
                        </span>
                    </div>
                    @foreach ($lista as $n)
                        <form method="POST" action="{{ route('notas.destroy', $n) }}" class="flex justify-between text-sm text-gray-600 mt-1">
                            @csrf @method('DELETE')
                            <span>{{ $n->descripcion }} ({{ $n->fecha->format('d/m/Y') }}): <b>{{ $n->valor }}</b></span>
                            <button class="text-red-600 hover:underline" onclick="return confirm('¿Eliminar esta nota?')">Eliminar</button>
                        </form>
                    @endforeach
                </div>
            @empty
                <p class="text-gray-500">No hay estudiantes matriculados en esta sección.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
