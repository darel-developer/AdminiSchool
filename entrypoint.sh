#!/bin/bash

# Appliquer le port dynamique de Railway
if [ -n "$PORT" ]; then
    echo "🔁 Remplacement du port Apache par $PORT"
    sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
    sed -i "s/:80/:${PORT}/" /etc/apache2/sites-available/000-default.conf
fi

# Lancer les migrations Laravel
php artisan migrate --force

# Lancer Apache
apache2-foreground
