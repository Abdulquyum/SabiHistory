FROM php:8.3-apache

# Install system deps, PHP extensions, Node.js, and Composer
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
    git \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    sqlite3 \
    libsqlite3-dev \
    curl \
    && docker-php-ext-install pdo_sqlite mbstring zip exif pcntl bcmath gd \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y --no-install-recommends nodejs \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Configure Apache to serve the Laravel public directory
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!/var/www/html/!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
    && a2enmod rewrite

WORKDIR /var/www/html

# Copy app source
COPY . .

# Create required Laravel directories
RUN mkdir -p database \
    && touch database/database.sqlite \
    && mkdir -p storage/framework/cache \
    && mkdir -p storage/framework/sessions \
    && mkdir -p storage/framework/views \
    && mkdir -p bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache database \
    && chmod -R 775 storage bootstrap/cache database

# Install PHP deps and build frontend assets
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader \
    && npm install \
    && npm run build \
    && php artisan storage:link \
    && php artisan migrate --force

EXPOSE 80

CMD ["apache2-foreground"]