@csrf
@isset($estudiante)
    @method('PUT')
@endisset

<h3>Datos del estudiante</h3>

<div class="campo">
    <label for="codigo">Código</label>
    <input type="text" name="codigo" id="codigo" maxlength="20"
           placeholder="Se genera automáticamente"
           value="{{ old('codigo', $estudiante->codigo ?? '') }}"
           {{ isset($estudiante) ? 'readonly' : '' }}>
    @error('codigo') <small class="error">{{ $message }}</small> @enderror
</div>

<div class="campo">
    <label for="dni">DNI</label>
    <input type="text" name="dni" id="dni" maxlength="15"
           value="{{ old('dni', $estudiante->dni ?? '') }}">
    @error('dni') <small class="error">{{ $message }}</small> @enderror
</div>

<div class="campo">
    <label for="nombres">Nombres</label>
    <input type="text" name="nombres" id="nombres" required
           value="{{ old('nombres', $estudiante->nombres ?? '') }}">
    @error('nombres') <small class="error">{{ $message }}</small> @enderror
</div>

<div class="campo">
    <label for="apellidos">Apellidos</label>
    <input type="text" name="apellidos" id="apellidos" required
           value="{{ old('apellidos', $estudiante->apellidos ?? '') }}">
    @error('apellidos') <small class="error">{{ $message }}</small> @enderror
</div>

<div class="campo">
    <label for="fecha_nacimiento">Fecha de nacimiento</label>
    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento"
           value="{{ old('fecha_nacimiento', isset($estudiante) ? optional($estudiante->fecha_nacimiento)->format('Y-m-d') : '') }}">
    @error('fecha_nacimiento') <small class="error">{{ $message }}</small> @enderror
</div>

<div class="campo">
    <label>
        <input type="checkbox" name="activo" value="1" @checked(old('activo', $estudiante->activo ?? true))>
        Activo
    </label>
</div>

<h3>Apoderado (opcional)</h3>

<div class="campo">
    <label for="ap_nombres">Nombres</label>
    <input type="text" name="ap_nombres" id="ap_nombres"
           value="{{ old('ap_nombres', $estudiante->apoderado->nombres ?? '') }}">
    @error('ap_nombres') <small class="error">{{ $message }}</small> @enderror
</div>

<div class="campo">
    <label for="ap_apellidos">Apellidos</label>
    <input type="text" name="ap_apellidos" id="ap_apellidos"
           value="{{ old('ap_apellidos', $estudiante->apoderado->apellidos ?? '') }}">
    @error('ap_apellidos') <small class="error">{{ $message }}</small> @enderror
</div>

<div class="campo">
    <label for="ap_dni">DNI</label>
    <input type="text" name="ap_dni" id="ap_dni" maxlength="15"
           value="{{ old('ap_dni', $estudiante->apoderado->dni ?? '') }}">
    @error('ap_dni') <small class="error">{{ $message }}</small> @enderror
</div>

<div class="campo">
    <label for="ap_telefono">Teléfono</label>
    <input type="text" name="ap_telefono" id="ap_telefono" maxlength="20"
           value="{{ old('ap_telefono', $estudiante->apoderado->telefono ?? '') }}">
    @error('ap_telefono') <small class="error">{{ $message }}</small> @enderror
</div>

<div class="campo">
    <label for="ap_email">Correo (para notificaciones)</label>
    <input type="email" name="ap_email" id="ap_email"
           value="{{ old('ap_email', $estudiante->apoderado->email ?? '') }}">
    @error('ap_email') <small class="error">{{ $message }}</small> @enderror
</div>

<button type="submit" class="btn">Guardar</button>
<a href="{{ route('estudiantes.index') }}">Cancelar</a>
