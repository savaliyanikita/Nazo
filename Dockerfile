# Stage 1: Build composer dependencies
FROM composer:2.7 AS build
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --optimize-autoloader
COPY . .

# Stage 2: Production image with PHP and Nginx
FROM php:8.2-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    nginx \
    git \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl && \
    docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Copy app files
WORKDIR /var/www/html
COPY --from=build /app ./

# Copy nginx config
COPY ./deploy/render-nginx.conf /etc/nginx/sites-available/default

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# Expose port
EXPOSE 80

# Start both Nginx and PHP-FPM
CMD service nginx start && php-fpm
