<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('ui.login') }} - {{ __('ui.app_name') }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Tahoma, Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: linear-gradient(135deg, #312e81, #6b21a8 55%, #0f172a);
        }
        .card {
            display: flex;
            width: 100%;
            max-width: 900px;
            min-height: 520px;
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0,0,0,.4);
        }
        .lado {
            flex: 1;
            padding: 40px;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: linear-gradient(160deg, #4f46e5, #7e22ce);
        }
        .lado .logo { font-size: 48px; margin-bottom: 16px; }
        .lado h1 { font-size: 28px; line-height: 1.25; margin-bottom: 24px; }
        .lado li { list-style: none; margin-bottom: 14px; font-size: 15px; color: #e0e7ff; }
        .form { flex: 1; padding: 48px 40px; display: flex; flex-direction: column; justify-content: center; }
        .form h2 { font-size: 26px; color: #1e293b; margin-bottom: 6px; }
        .form .sub { color: #64748b; font-size: 14px; margin-bottom: 28px; }
        .campo { margin-bottom: 18px; }
        .campo label { display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px; }
        .campo input[type=email], .campo input[type=password], .campo input[type=text] {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            font-size: 15px;
            outline: none;
        }
        .campo input:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,.2); }
        .pass { position: relative; }
        .pass input { padding-right: 44px; }
        .ojo {
            position: absolute; right: 8px; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer; font-size: 18px; padding: 4px 6px;
        }
        .fila { display: flex; justify-content: space-between; align-items: center; margin-bottom: 22px; font-size: 13px; }
        .fila label { color: #475569; display: flex; align-items: center; gap: 6px; }
        .fila a { color: #4f46e5; text-decoration: none; }
        .fila a:hover { text-decoration: underline; }
        .btn {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            cursor: pointer;
            background: linear-gradient(90deg, #4f46e5, #7e22ce);
        }
        .btn:hover { opacity: .92; }
        .error { color: #dc2626; font-size: 13px; margin-top: 5px; }
        .estado { background: #dcfce7; color: #166534; padding: 10px; border-radius: 8px; font-size: 13px; margin-bottom: 16px; }
        .pie { text-align: center; margin-top: 22px; font-size: 13px; color: #94a3b8; }
        @media (max-width: 720px) {
            .lado { display: none; }
            .form { padding: 36px 24px; }
        }
    </style>
</head>
<body>
    {{-- Selector de idioma: justo después de abrir <body> --}}
    <div style="position: fixed; top: 20px; right: 20px; z-index: 50; background: rgba(255,255,255,.9); border-radius: 12px;">
        <x-language-switcher />
    </div>

    <div class="card">

        <div class="lado">
            <div class="logo">🎓</div>
            <h1>{{ __('ui.app_name') }}</h1>
            <ul>
                <li>✅ {{ __('ui.feat_attendance') }}</li>
                <li>📝 {{ __('ui.feat_grades') }}</li>
                <li>📊 {{ __('ui.feat_reports') }}</li>
            </ul>
        </div>

        <div class="form">
            <h2>{{ __('ui.welcome') }} 👋</h2>
            <p class="sub">{{ __('ui.subtitle') }}</p>

            @if (session('status'))
                <div class="estado">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="campo">
                    <label for="email">{{ __('ui.email') }}</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           placeholder="{{ __('ui.email_placeholder') }}" required autofocus autocomplete="username">
                    @error('email') <p class="error">{{ $message }}</p> @enderror
                </div>

                <div class="campo">
                    <label for="password">{{ __('ui.password') }}</label>
                    <div class="pass">
                        <input id="password" type="password" name="password"
                               placeholder="••••••••" required autocomplete="current-password">
                        <button type="button" class="ojo" id="verPass" aria-label="{{ __('ui.show_password') }}">👁️</button>
                    </div>
                    @error('password') <p class="error">{{ $message }}</p> @enderror
                </div>

                <div class="fila">
                    <label><input type="checkbox" name="remember"> {{ __('ui.remember') }}</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">{{ __('ui.forgot') }}</a>
                    @endif
                </div>

                <button type="submit" class="btn">{{ __('ui.login') }}</button>
            </form>

            <p class="pie">{{ __('ui.no_account') }}</p>
        </div>
    </div>

    <script>
        const campo = document.getElementById('password');
        const ojo = document.getElementById('verPass');
        ojo.addEventListener('click', () => {
            const oculto = campo.type === 'password';
            campo.type = oculto ? 'text' : 'password';
            ojo.textContent = oculto ? '🙈' : '👁️';
        });
    </script>
</body>
</html>
