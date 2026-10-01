@csrf

<label>Código</label>
<input type="text" name="codigo" value="{{ old('codigo', $curso->codigo ?? '') }}" required>
@error('codigo') <small style="color:#dc2626">{{ $message }}</small> @enderror

<label>Nombre</label>
<input type="text" name="nombre" value="{{ old('nombre', $curso->nombre ?? '') }}" required>
@error('nombre') <small style="color:#dc2626">{{ $message }}</small> @enderror

<label>Descripción</label>
<textarea name="descripcion" rows="3">{{ old('descripcion', $curso->descripcion ?? '') }}</textarea>
@error('descripcion') <small style="color:#dc2626">{{ $message }}</small> @enderror

<label>
    <input type="checkbox" name="activo" value="1"
           {{ old('activo', $curso->activo ?? true) ? 'checked' : '' }}>
    Activo
</label>

<div class="acciones">
    <button class="btn">Guardar</button>
    <a href="{{ route('cursos.index') }}" class="btn btn-chico">Cancelar</a>
</div>
