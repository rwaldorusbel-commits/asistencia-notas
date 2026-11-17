<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TV Asistencia</title>
    <style>
        body {
            background: #0f172a; color: white; font-family: sans-serif;
            margin: 0; padding: 40px; overflow: hidden;
            display: flex; flex-direction: column; align-items: center;
        }
        h1 { font-size: 3rem; color: #818cf8; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 2px; }
        #estado { color: #94a3b8; font-size: 1.5rem; margin-bottom: 20px; }
        #toast-container { display: flex; flex-direction: column; gap: 20px; width: 100%; align-items: center; }
        .toast-tv {
            background: #4f46e5; padding: 40px 60px; border-radius: 20px;
            font-size: 2.5rem; font-weight: bold; box-shadow: 0 20px 50px rgba(0,0,0,0.5);
            animation: slideIn 0.5s ease-out; text-align: center;
        }
        @keyframes slideIn {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>
</head>
<body>
    <h1>📢 Avisos de Asistencia</h1>
    <div id="estado">Esperando notificaciones...</div>
    <div id="toast-container"></div>

    <!-- Usamos la versión 7 de Pusher que no da error de cluster -->
    <script src="https://js.pusher.com/7.6.0/pusher.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Configuración con tus datos reales
            const pusher = new Pusher('fakktbrjojf8srlsju93', {
                wsHost: '192.168.16.169',
                wsPort: 8080,
                forceTLS: false,
                enabledTransports: ['ws'],
            });

            pusher.connection.bind('connected', () => {
                console.log('✅ TV conectada a Reverb');
                document.getElementById('estado').innerText = '🟢 Conectado. Esperando avisos...';
            });

            const channel = pusher.subscribe('asistencias-global');

            channel.bind('AsistenciaTomada', function(data) {
                console.log("¡Mensaje recibido!", data);

                const container = document.getElementById('toast-container');
                const toast = document.createElement('div');
                toast.className = 'toast-tv';
                toast.innerHTML = `<strong>🔔</strong><br>${data.mensaje}`;

                container.appendChild(toast);

                setTimeout(() => {
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 500);
                }, 8000);
            });
        });
    </script>
</body>
</html>
