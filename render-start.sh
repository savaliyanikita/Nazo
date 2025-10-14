#!/usr/bin/env bash
set -e

echo "🚀 Starting Laravel setup ..."

# Ensure key exists
if [ -z "$APP_KEY" ]; then
  echo "⚙️ Generating APP_KEY ..."
  php artisan key:generate --force
fi

# Clear caches
php artisan config:clear
php artisan route:clear
php artisan cache:clear

# Run database migrations
echo "📦 Running migrations..."
php artisan migrate --force || echo "⚠️ Migration failed or already up to date."

# Link storage if not linked
if [ ! -L "public/storage" ]; then
  php artisan storage:link || true
fi

# Optimize for production
php artisan config:cache
# php artisan route:cache
php artisan view:cache

echo "✅ Laravel setup complete. Starting services..."

# Start PHP-FPM and Nginx
service nginx start
php-fpm
