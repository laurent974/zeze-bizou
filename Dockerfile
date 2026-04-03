# Dockerfile
FROM php:8.4-fpm

# Installer les dépendances nécessaires
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libzip-dev \
    && docker-php-ext-install pdo_mysql zip

# Installer Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

WORKDIR /var/www/wordpress

# Copier composer.json et composer.lock d'abord pour profiter du cache Docker
COPY composer.json composer.lock ./

# Installer les dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Copier tout le projet
COPY . .

# Entrypoint pour lancer PHP-FPM
CMD ["php-fpm"]
