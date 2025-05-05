FROM php:8.2-apache

# 1. Installation des dépendances système
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    nodejs npm default-mysql-client \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# 2. Configuration Apache
RUN a2enmod rewrite
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 3. Installation de Composer (version spécifique pour stabilité)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.5.8

# 4. Préparation du workspace
WORKDIR /var/www/html

# 5. Copie SÉLECTIVE des fichiers nécessaires
COPY composer.json composer.lock ./

# 6. Vérification des fichiers copiés (debug)
RUN ls -la && pwd



# Correction des permissions AVANT la copie des fichiers
RUN mkdir -p storage/framework/{sessions,views,cache} \
    && mkdir -p bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Copie des fichiers
COPY . .

# Réapplication des permissions APRÈS la copie
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache \
    && [ -d "/var/www/html/storage/logs" ] || mkdir -p /var/www/html/storage/logs \
    && touch /var/www/html/storage/logs/laravel.log \
    && chown www-data:www-data /var/www/html/storage/logs/laravel.log

# 8. Installation des dépendances PHP avec timeout augmenté
RUN composer install --no-interaction --no-dev --no-progress --no-scripts || \
    (echo "Composer install failed, retrying..." && composer install --no-interaction --no-dev)

# 9. Installation des dépendances Node.js
RUN npm install --force




# 11. Build des assets
RUN npm run build

COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80
ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]