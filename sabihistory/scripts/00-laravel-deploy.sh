#!/usr/bin/env bash

echo "Running composer install (without dev dependencies)"
composer install --no-dev --working-dir=/var/www/html

echo "Caching Laravel configuration"
php artisan config:cache

echo "Caching Laravel routes"
php artisan route:cache

echo "Preparing SQLite database"
mkdir -p database
touch database/database.sqlite

echo "Running database migrations"
php artisan migrate --force

echo "Laravel deployment script finished"