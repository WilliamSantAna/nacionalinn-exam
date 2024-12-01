#FROM php:8.1-fpm
FROM php:8.2-fpm

RUN apt-get update
RUN apt-get install -y \
    zip \
    unzip \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY /app /var/www/html
WORKDIR /var/www/html

# Instalar dependências do Laravel
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer update

# Configurar permissões
RUN chown -R www-data:www-data /var/www/html
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

CMD ["php-fpm"]
