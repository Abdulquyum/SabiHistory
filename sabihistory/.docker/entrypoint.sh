#!/bin/sh
set -e

cd /var/www/html

if [ ! -f vendor/autoload.php ]; then
    echo "Installing Composer dependencies..."
    composer install --no-interaction --optimize-autoloader --no-dev
fi

mkdir -p database
touch database/database.sqlite

php artisan migrate --force --no-interaction

if [ ! -L public/storage ]; then
    php artisan storage:link --no-interaction || true
fi

exec "$@"
