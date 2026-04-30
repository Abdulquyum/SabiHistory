# Build stage
FROM composer:2.8 as composer

FROM php:8.3-fpm-alpine as app

RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www/html

# Copy the application code
COPY . .

# Install PHP dependencies from composer.json
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN composer install --no-interaction --optimize-autoloader --no-dev

ENV PORT=8000
ENTRYPOINT [ "sh", "-c", "php artisan migrate --force && php artisan optimize:clear && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan storage:link && php artisan serve --host=0.0.0.0 --port=${PORT}" ]