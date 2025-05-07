FROM php:8.3-apache

# Installe les extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    libonig-dev libzip-dev unzip curl git zip \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev libxml2-dev libwebp-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl gd

# Active mod_rewrite d'Apache
RUN a2enmod rewrite

# Change le DocumentRoot vers /var/www/html/public
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Installe Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copie tout le projet
COPY . /var/www/html

# Va dans le dossier de travail
WORKDIR /var/www/html

# Installe les dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Installe les dépendances JS si tu utilises Laravel Mix ou Inertia/Vue/React
RUN [ -f package.json ] && npm install && npm run build || echo "Pas de frontend JS"

# Donne les bonnes permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose le port utilisé par Apache
EXPOSE 80
