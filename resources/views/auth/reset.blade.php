<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Restablecer contraseña</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            min-height: 100vh;
            padding: 20px;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        }
        .card {
            width: 100%;
            max-width: 420px;
            margin: 40px auto;
            background: #fff;
            border-radius: 16px;
            padding: 36px 32px;
            box-shadow: 0 20px 45px rgba(0, 0, 0, .2);
        }
        .icon {
            width: 56px; height: 56px;
            margin: 0 auto 16px;
            border-radius: 50%;
            background: #eef2ff;
            display: flex; align-items: center; justify-content: center;
            font-size: 26px;
        }
        h1 { text-align: center; font-size: 22px; color: #1f2937; margin-bottom: 6px; }
        .sub { text-align: center; font-size: 14px; color: #6b7280; margin-bottom: 24px; }
        label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px; }
        input {
            width: 100%;
            padding: 12px 14px;
            margin-bottom: 16px;
            font-size: 15px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }
        input:focus { border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79, 70, 229, .15); }
        input[readonly] { background: #f3f4f6; color: #6b7280; cursor: not-allowed; }
        .pass-wrap { position: relative; }
        .pass-wrap input { padding-right: 70px; }
        .toggle {
            position: absolute; right: 12px; top: 12px;
            width: auto; padding: 0; background: none; border: none;
            color: #4f46e5; font-size: 13px; font-weight: 600; cursor: pointer;
        }
        .toggle:hover { background: none; text-decoration: underline; }
        button[type=submit] {
            width: 100%;
            padding: 13px;
            font-size: 15px;
            font-weight: 600;
            color: #fff;
            background: #4f46e5;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background .2s;
        }
        button[type=submit]:hover { background: #4338ca; }
        .error {
            background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca;
            border-radius: 8px; padding: 10px 12px; font-size: 13px; margin-bottom: 16px;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">🔒</div>
        <h1>Nueva contraseña</h1>
        <p class="sub">Escribe tu nueva contraseña para continuar.</p>

        @error('email') <div class="error">{{ $message }}</div> @enderror
        @error('password') <div class="error">{{ $message }}</div> @enderror

        <form method="POST" action="{{ route('password.reset.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <label for="email">Correo</label>
            <input id="email" type="email" name="email" value="{{ old('email', $email) }}" readonly required>

            <label for="password">Nueva contraseña</label>
            <div class="pass-wrap">
                <input id="password" type="password" name="password" placeholder="Mínimo 8 caracteres" required autofocus>
                <button type="button" class="toggle" onclick="ver('password', this)">Ver</button>
            </div>

            <label for="password_confirmation">Repite la contraseña</label>
            <div class="pass-wrap">
                <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Vuelve a escribirla" required>
                <button type="button" class="toggle" onclick="ver('password_confirmation', this)">Ver</button>
            </div>

            <button type="submit">Cambiar contraseña</button>
        </form>
    </div>

    <script>
        function ver(id, btn) {
            var campo = document.getElementById(id);
            var oculto = campo.type === 'password';
            campo.type = oculto ? 'text' : 'password';
            btn.textContent = oculto ? 'Ocultar' : 'Ver';
        }
    </script>
</body>
</html>
