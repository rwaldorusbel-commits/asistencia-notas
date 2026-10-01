@csrf
@isset($periodo)
    @method('PUT')
@endisset

<div class="campo">
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" id="nombre" required
           value="{{ old('nombre', $periodo->nombre ?? '') }}" placeholder="Ej: 2026-I">
    @error('nombre') <small class="error">{{ $message }}</small> @enderror
</div>

<div class="campo">
    <label for="anio">Año</label>
    <input type="number" name="anio" id="anio" required
           value="{{ old('anio', $periodo->anio ?? date('Y')) }}">
    @error('anio') <small class="error">{{ $message }}</small> @enderror
</div>

<div class="campo">
    <label for="tipo">Tipo</label>
    <select name="tipo" id="tipo" required>
        @foreach (['anual', 'semestre', 'bimestre'] as $t)
            <option value="{{ $t }}" @selected(old('tipo', $periodo->tipo ?? 'semestre') == $t)>{{ ucfirst($t) }}</option>
        @endforeach
    </select>
    @error('tipo') <small class="error">{{ $message }}</small> @enderror
</div>

<div class="campo">
    <label for="fecha_inicio">Fecha de inicio</label>
    <input type="date" name="fecha_inicio" id="fecha_inicio" required
           value="{{ old('fecha_inicio', isset($periodo) ? \Illuminate\Support\Carbon::parse($periodo->fecha_inicio)->format('Y-m-d') : '') }}">
    @error('fecha_inicio') <small class="error">{{ $message }}</small> @enderror
</div>

<div class="campo">
    <label for="fecha_fin">Fecha de fin</label>
    <input type="date" name="fecha_fin" id="fecha_fin" required
           value="{{ old('fecha_fin', isset($periodo) ? \Illuminate\Support\Carbon::parse($periodo->fecha_fin)->format('Y-m-d') : '') }}">
    @error('fecha_fin') <small class="error">{{ $message }}</small> @enderror
</div>

<div class="campo">
    <label>
        <input type="checkbox" name="activo" value="1"
               @checked(old('activo', $periodo->activo ?? true))>
        Activo
    </label>
</div>

<button type="submit" class="btn">Guardar</button>
<a href="{{ route('periodos.index') }}">Cancelar</a>
