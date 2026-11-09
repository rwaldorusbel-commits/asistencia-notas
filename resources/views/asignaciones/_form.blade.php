@csrf

<label>Sección</label>
<select name="seccion_id" required>
    <option value="">Seleccione...</option>
    @foreach ($secciones as $s)
        <option value="{{ $s->id }}"
            {{ old('seccion_id', $asignacion->seccion_id ?? '') == $s->id ? 'selected' : '' }}>
            {{ $s->periodo?->nombre }} - {{ $s->grado?->nombre }} {{ $s->nombre }}
        </option>
    @endforeach
</select>
@error('seccion_id') <small style="color:#dc2626">{{ $message }}</small> @enderror

<label>Curso</label>
<select name="curso_id" required>
    <option value="">Seleccione...</option>
    @foreach ($cursos as $c)
        <option value="{{ $c->id }}"
            {{ old('curso_id', $asignacion->curso_id ?? '') == $c->id ? 'selected' : '' }}>
            {{ $c->codigo }} - {{ $c->nombre }}
        </option>
    @endforeach
</select>
@error('curso_id') <small style="color:#dc2626">{{ $message }}</small> @enderror

<label>Docente</label>
<select name="docente_id" required>
    <option value="">Seleccione...</option>
    @foreach ($docentes as $d)
        <option value="{{ $d->id }}"
            {{ old('docente_id', $asignacion->docente_id ?? '') == $d->id ? 'selected' : '' }}>
            {{ $d->name }}
        </option>
    @endforeach
</select>
@error('docente_id') <small style="color:#dc2626">{{ $message }}</small> @enderror

<label>
    <input type="checkbox" name="activo" value="1"
           {{ old('activo', $asignacion->activo ?? true) ? 'checked' : '' }}>
    Activa
</label>

<div class="acciones">
    <button class="btn">Guardar</button>
    <a href="{{ route('asignaciones.index') }}" class="btn btn-chico">Cancelar</a>
</div>
