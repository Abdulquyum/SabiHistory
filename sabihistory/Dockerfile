# Use the richarvey/nginx-php-fpm image (includes php8.2-fpm and nginx)[reference:0]
FROM richarvey/nginx-php-fpm:latest

# Copy the entire application into the container
COPY . .

# Configure nginx to serve from the public directory
ENV WEBROOT /var/www/html/public

# Optimize Laravel for stderr logging – great for Render log streaming
ENV LOG_CHANNEL stderr

# Disable the built‑in composer run; we run it ourselves in the start script
ENV SKIP_COMPOSER 1

# General container optimizations
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Laravel environment (overridden by Render Environment Variables)
ENV APP_ENV production
ENV APP_DEBUG false

# Allow composer to run as root inside the container
ENV COMPOSER_ALLOW_SUPERUSER 1

# CMD is provided by the base image – it starts nginx and php-fpm