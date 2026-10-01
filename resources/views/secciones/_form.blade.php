@csrf


<label>Periodo</label>
<select name="periodo_id" required>
    <option value="">Seleccione...</option>
    @foreach ($periodos as $p)
        <option value="{{ $p->id }}"
            {{ old('periodo_id', $seccion->periodo_id ?? '') == $p->id ? 'selected' : '' }}>
            {{ $p->nombre }}
        </option>
    @endforeach
</select>
@error('periodo_id') <small style="color:#dc2626">{{ $message }}</small> @enderror

<label>Grado</label>
<input type="text" name="grado_id" placeholder="Ej. 1° Secundaria"
       value="{{ old('grado_id', $seccion->grado ?? '') }}" required>
@error('grado_id') <small style="color:#dc2626">{{ $message }}</small> @enderror

<label>Sección</label>
<input type="text" name="nombre" placeholder="Ej. A"
       value="{{ old('nombre', $seccion->nombre ?? '') }}" required>
@error('nombre') <small style="color:#dc2626">{{ $message }}</small> @enderror

<label>Capacidad</label>
<input type="number" name="capacidad" min="1" max="100"
       value="{{ old('capacidad', $seccion->capacidad ?? 30) }}" required>
@error('capacidad') <small style="color:#dc2626">{{ $message }}</small> @enderror

<label>
    <input type="checkbox" name="activo" value="1"
           {{ old('activo', $seccion->activo ?? true) ? 'checked' : '' }}>
    Activa
</label>

<div class="acciones">
    <button class="btn">Guardar</button>
    <a href="{{ route('secciones.index') }}" class="btn btn-chico">Cancelar</a>
</div>
