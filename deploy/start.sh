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

echo "⏳ Waiting for database..."
until php -r "try { new PDO(getenv('DB_CONNECTION') . ':host=' . getenv('DB_HOST')); exit(0); } catch (Exception \$e) { exit(1); }"; do
  echo "Database not ready, retrying in 3s..."
  sleep 3
done

# Run database migrations
php artisan migrate --force || true

# Link storage
php artisan storage:link || true

# Optimize for production
php artisan optimize || true

echo "✅ Laravel setup complete — starting Nginx and PHP-FPM..."

service nginx start
# Default PORT to 8080 if not set
export PORT=${PORT:-8080}

# Update Nginx port dynamically
sed -i "s/listen 80;/listen ${PORT};/" /etc/nginx/sites-available/default

echo "Starting Nginx and PHP-FPM on port ${PORT}..."
php-fpm -D
nginx -g "daemon off;"