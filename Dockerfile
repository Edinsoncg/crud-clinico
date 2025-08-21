# Imagen base con PHP 8.2 y FPM
FROM php:8.2-fpm

# Instalar dependencias del sistema y extensiones de PHP necesarias para Laravel
RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev libpng-dev libjpeg-dev libfreetype6-dev libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql zip gd mbstring exif pcntl bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar Composer desde la imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Definir carpeta de trabajo
WORKDIR /var/www

# Dar permisos a Laravel (cuando lo instales)
RUN mkdir -p /var/www/storage /var/www/bootstrap/cache \
    && chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Comando por defecto (php-fpm escuchará en 9000 por defecto)
CMD ["php-fpm"]
