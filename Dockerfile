FROM php:8.2-apache

# System deps + PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev libzip-dev libonig-dev unzip git \
    && docker-php-ext-install gd zip pdo pdo_pgsql pgsql \
    && a2enmod rewrite

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --no-interaction --no-dev --prefer-dist --no-scripts \
    && php artisan storage:link || true

# Point Apache at Laravel's public/ dir
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

EXPOSE 80

CMD php artisan migrate --force && apache2-foreground
