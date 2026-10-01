@csrf

<label>Nombre completo</label>
<input type="text" name="name" required value="{{ old('name', $docente->name ?? '') }}">
@error('name') <small style="color:#dc2626">{{ $message }}</small> @enderror

<label>Correo</label>
<input type="email" name="email" required value="{{ old('email', $docente->email ?? '') }}">
@error('email') <small style="color:#dc2626">{{ $message }}</small> @enderror

<label>{{ isset($docente) ? 'Nueva contraseña (déjala vacía para no cambiarla)' : 'Contraseña inicial' }}</label>
<input type="password" name="password" minlength="8" {{ isset($docente) ? '' : 'required' }}>
@error('password') <small style="color:#dc2626">{{ $message }}</small> @enderror

<label>
    <input type="checkbox" name="activo" value="1"
           {{ old('activo', $docente->activo ?? true) ? 'checked' : '' }}>
    Activo
</label>

<div class="acciones">
    <button class="btn">Guardar</button>
    <a href="{{ route('docentes.index') }}" class="btn btn-chico">Cancelar</a>
</div>
