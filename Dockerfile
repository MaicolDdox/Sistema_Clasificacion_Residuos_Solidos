FROM php:8.3-fpm

WORKDIR /var/www

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libicu-dev \
    zip \
    curl

# Extensiones PHP necesarias
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    zip \
    intl \
    xml \
    mbstring \
    exif

# GD (para imágenes, requerido por varias libs)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar proyecto
COPY . .

# Instalar dependencias Laravel
RUN composer install --no-dev --optimize-autoloader

# Permisos (muy importante en Laravel)
RUN chmod -R 775 storage bootstrap/cache

CMD ["php-fpm"]