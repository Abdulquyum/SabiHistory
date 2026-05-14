# Use the official PHP 8.3 FPM image as the base
FROM php:8.3-fpm-alpine AS base

# Install system dependencies, nginx, PostgreSQL client, and required dev libraries
RUN apk add --no-cache nginx supervisor \
    postgresql-client \
    libpq-dev \
    oniguruma-dev \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring zip gd pdo_pgsql

# Copy Composer from its official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set the working directory
WORKDIR /var/www/html

# Copy the application code
COPY . .

# Create a start script
RUN echo '#!/bin/sh' > /start.sh && \
    echo 'composer install --no-interaction --optimize-autoloader --no-dev' >> /start.sh && \
    echo 'php artisan key:generate --force' >> /start.sh && \
    echo 'php artisan migrate --force' >> /start.sh && \
    echo 'php artisan config:cache' >> /start.sh && \
    echo 'php artisan route:cache' >> /start.sh && \
    echo 'php artisan view:cache' >> /start.sh && \
    echo 'php artisan storage:link' >> /start.sh && \
    echo 'mkdir -p /run/nginx' >> /start.sh && \
    echo 'supervisord -c /etc/supervisord.conf' >> /start.sh && \
    chmod +x /start.sh

# Copy Nginx configuration file
COPY nginx.conf /etc/nginx/http.d/default.conf

# Copy Supervisor configuration file
COPY supervisord.conf /etc/supervisord.conf

# Expose port 80
EXPOSE 80

CMD ["/start.sh"]