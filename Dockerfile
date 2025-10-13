# Stage 1: Build composer dependencies
FROM composer:2.7 AS build
WORKDIR /app

# Copy full application first (not just composer.json)
COPY . .

# Install dependencies (no dev packages)
RUN composer install --no-dev --no-interaction --optimize-autoloader


# Stage 2: Production image with PHP + Nginx
FROM php:8.2-fpm

# Install system dependencies & PHP extensions
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

WORKDIR /var/www/html

# Copy built app from previous stage
COPY --from=build /app ./

# Copy nginx config
COPY ./deploy/render-nginx.conf /etc/nginx/sites-available/default

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

EXPOSE 80

# Start both Nginx and PHP-FPM
COPY ./deploy/start.sh /start.sh
RUN chmod +x /start.sh
CMD ["/start.sh"]
