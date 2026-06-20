# Use the official PHP 8.3 FPM image as the base
FROM php:8.3-fpm-alpine AS app

# Install system dependencies, nginx, and required dev libraries
RUN apk add --no-cache nginx supervisor git unzip \
    && apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        freetype-dev \
        libjpeg-turbo-dev \
        libpng-dev \
        libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" gd zip \
    && apk del .build-deps

# Copy Composer from its official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Install PHP dependencies (cached layer when composer files unchanged)
COPY composer.json composer.lock* ./
RUN composer install --no-interaction --optimize-autoloader --no-dev --no-scripts

COPY . .

RUN composer dump-autoload --optimize --no-interaction

COPY .docker/entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Copy Nginx configuration file (for single-container deploy)
COPY nginx.conf /etc/nginx/http.d/default.conf

# Copy Supervisor configuration file (for single-container deploy)
COPY supervisord.conf /etc/supervisord.conf

# Create a start script for single-container deploy (nginx + php-fpm)
RUN echo '#!/bin/sh' > /start.sh && \
    echo 'mkdir -p /run/nginx' >> /start.sh && \
    echo 'supervisord -c /etc/supervisord.conf' >> /start.sh && \
    chmod +x /start.sh

EXPOSE 80 9000

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["php-fpm"]
