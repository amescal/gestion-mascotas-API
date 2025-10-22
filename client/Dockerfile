# Imagen oficial de PHP con Apache
FROM php:8.2-apache

# Directorio de trabajo
WORKDIR /var/www/html

# Instala extensiones necesarias y unzip para composer
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libzip-dev \
    zip \
    curl \
    git \
    unzip \
    && docker-php-ext-install pdo pdo_mysql mbstring zip

# Habilita mod_rewrite (opcional)
RUN a2enmod rewrite

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia todo el proyecto
COPY . .

# Instala dependencias de PHP
RUN composer install --no-interaction --optimize-autoloader

# Apache servirá los archivos PHP directamente, no hace falta php artisan