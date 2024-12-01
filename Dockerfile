FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Instalar Laravel
RUN composer create-project --prefer-dist laravel/laravel .

# Configurar permissões
RUN chown -R www-data:www-data /var/www/html

CMD ["php-fpm"]
