#!/bin/bash
set -e

# Navigate to project root
cd /var/www/html

echo "🔧 Running Laravel setup tasks..."

# Fix permissions
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Clear and rebuild Laravel caches
php artisan config:clear || true
php artisan cache:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Ensure app key exists (skip if already set)
php artisan key:generate --force || true

# Run database migrations
php artisan migrate --force || true

# Link storage
php artisan storage:link || true

# Optimize for production
php artisan optimize || true

echo "✅ Laravel setup complete — starting Nginx and PHP-FPM..."
service nginx start
php-fpm
