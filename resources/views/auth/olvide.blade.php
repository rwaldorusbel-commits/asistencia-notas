<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recuperar contraseña</title>
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
        button {
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
        button:hover { background: #4338ca; }
        .error {
            background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca;
            border-radius: 8px; padding: 10px 12px; font-size: 13px; margin-bottom: 16px;
        }
        .ok {
            background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0;
            border-radius: 8px; padding: 10px 12px; font-size: 13px; margin-bottom: 16px;
        }
        .back {
            display: block; text-align: center; margin-top: 18px;
            font-size: 14px; color: #4f46e5; text-decoration: none;
        }
        .back:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">✉️</div>
        <h1>¿Olvidaste tu contraseña?</h1>
        <p class="sub">Escribe tu correo y te enviaremos un enlace para restablecerla.</p>

        @if (session('message')) <div class="ok">{{ session('message') }}</div> @endif
        @error('email') <div class="error">{{ $message }}</div> @enderror

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <label for="email">Correo registrado</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="tucorreo@ejemplo.com" required autofocus>
            <button type="submit">Enviar enlace de recuperación</button>
        </form>

        <a class="back" href="{{ route('login') }}">← Volver a iniciar sesión</a>
    </div>
</body>
</html>
