@if (session('message')) <p>{{ session('message') }}</p> @endif

<form method="POST" action="/ajustes/correo">
    @csrf
    <input name="username" type="email" placeholder="tucorreo@gmail.com" value="{{ $m->username ?? '' }}">
    <input name="password" type="password" placeholder="Contraseña de aplicación (16 caracteres)">
    <input name="from_name" placeholder="Nombre del remitente" value="{{ $m->from_name ?? '' }}">
    <button type="submit">Guardar</button>
</form>
