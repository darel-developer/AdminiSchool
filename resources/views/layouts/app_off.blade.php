<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#2c3e50">
    <link rel="manifest" href="/manifest.json">
    <title>AdminiSchool</title>
    <script>
        // Initialisation PWA
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(registration => {
                        console.log('SW registered:', registration);
                    })
                    .catch(registrationError => {
                        console.log('SW registration failed:', registrationError);
                    });
            });
        }

        // Gestion de l'état de connexion
        function updateOnlineStatus() {
            const statusElement = document.getElementById('connection-status');
            if (navigator.onLine) {
                statusElement?.classList.add('hidden');
            } else {
                statusElement?.classList.remove('hidden');
            }
        }

        window.addEventListener('online', updateOnlineStatus);
        window.addEventListener('offline', updateOnlineStatus);
        document.addEventListener('DOMContentLoaded', updateOnlineStatus);
    </script>
    @laravelPWA
</head>
<body>
    <div id="connection-status" class="hidden fixed bottom-0 left-0 right-0 bg-yellow-500 text-white p-2 text-center">
        Vous êtes hors ligne - Mode hors ligne activé
    </div>

    @yield('content')

    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ mix('js/offlineDB.js') }}"></script>
    <script src="{{ mix('js/offlineInterceptor.js') }}"></script>
</body>
</html>