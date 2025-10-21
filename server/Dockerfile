# Usa una imagen oficial de PHP con Apache y PHP 8.1 
FROM php:8.1-apache 

# Configura el directorio de trabajo 
WORKDIR /var/www/html 

# Instala dependencias necesarias para Laravel 
RUN apt-get update && apt-get install -y \ 
git \ 
unzip \ 
libonig-dev \ 
libzip-dev \ 
zip \ 
curl \ 
&& docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl 

# Habilita mod_rewrite para Apache 
RUN a2enmod rewrite 

# Instala Composer 
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer 

# Copia todo el proyecto al contenedor 
COPY . . 

# Copia el archivo de configuración de Apache para Laravel (opcional) 
# Si quieres usarlo, crea un archivo server.conf en la carpeta server 
#Lo dejo comentado porque al usar render no es necesario
# COPY server.conf /etc/apache2/sites-available/000-default.conf 

# Instala dependencias de PHP con Composer 
RUN composer install --no-interaction --optimize-autoloader 

# Expone el puerto que Render usará 
# Tampoco es necesario usando render porque asigna un puerto aleatorio que ya expone
# EXPOSE 10000 

# Comando para iniciar el servidor PHP embebido con el puerto dinámico que Render asigna automáticamente 
CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=$PORT"]
