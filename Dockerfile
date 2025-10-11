# Use the official PHP image
FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl \
    && docker-php-ext-install zip

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Generate Laravel APP key (optional: you can also set manually in Render)
RUN php artisan key:generate

# Expose port
EXPOSE 10000

# Start the Laravel development server
CMD php artisan serve --host=0.0.0.0 --port=10000
