<!-- resources/views/matriculas/create.blade.php -->
<x-layout>
    <x-slot:titulo>
        Nueva matrícula
    </x-slot>

    <div class="encabezado"><h1>📝 Nueva matrícula</h1></div>
    <div class="tarjeta">
        <form method="POST" action="{{ route('matriculas.store') }}">
            @csrf

            <div class="campo">
                <label for="estudiante_id">Estudiante</label>
                <select name="estudiante_id" id="estudiante_id" required>
                    <option value="">-- Selecciona --</option>
                    @foreach ($estudiantes as $e)
                        <option value="{{ $e->id }}" @selected(old('estudiante_id') == $e->id)>
                            {{ $e->apellidos }}, {{ $e->nombres }} ({{ $e->codigo }})
                        </option>
                    @endforeach
                </select>
                @error('estudiante_id') <small class="error">{{ $message }}</small> @enderror
            </div>

            <div class="campo">
                <label for="seccion_id">Sección (el periodo se toma de ella)</label>
                <select name="seccion_id" id="seccion_id" required>
                    <option value="">-- Selecciona --</option>
                    @foreach ($secciones as $s)
                        <option value="{{ $s->id }}" @selected(old('seccion_id') == $s->id)>
                            {{ $s->periodo->nombre ?? '' }} - {{ $s->grado->nombre ?? '' }} {{ $s->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('seccion_id') <small class="error">{{ $message }}</small> @enderror
            </div>

            <div class="campo">
                <label for="fecha_matricula">Fecha de matrícula</label>
                <input type="date" name="fecha_matricula" id="fecha_matricula" required
                       value="{{ old('fecha_matricula', date('Y-m-d')) }}">
                @error('fecha_matricula') <small class="error">{{ $message }}</small> @enderror
            </div>

            <button type="submit" class="btn">Matricular</button>
            <a href="{{ route('matriculas.index') }}">Cancelar</a>
        </form>
    </div>
</x-layout>
