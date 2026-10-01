#!/bin/sh
set -e

# Default PORT to 8000 if not provided
PORT="${PORT:-8000}"

echo "Configuring Nginx to listen on port ${PORT}..."
sed -i "s/listen [0-9]\+;/listen ${PORT};/g" /etc/nginx/http.d/default.conf || true

# Ensure framework storage directories exist
mkdir -p /var/www/html/storage/framework/cache/data
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/bootstrap/cache
mkdir -p /var/www/html/database

# Ensure correct database directory and file permissions
mkdir -p /var/www/html/database
DB_FILE="${DB_DATABASE:-/var/www/html/database/database.sqlite}"
if [ "$DB_CONNECTION" = "sqlite" ] || [ -z "$DB_CONNECTION" ]; then
    if [ ! -f "$DB_FILE" ]; then
        echo "Initializing SQLite database file at ${DB_FILE}..."
        touch "$DB_FILE"
    fi
fi

# Ensure full write permissions for web server on storage, cache, and database
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 777 /var/www/html/database
if [ -f "$DB_FILE" ]; then
    chmod 666 "$DB_FILE"
fi

# Generate APP_KEY if missing
if [ -z "$APP_KEY" ]; then
    echo "APP_KEY is not set. Generating application key..."
    php artisan key:generate --force || true
fi

# Run database migrations so sessions, users, and audit tables exist
echo "Running database migrations..."
php artisan migrate --force || true

# Production cache optimization
if [ "$APP_ENV" = "production" ]; then
    echo "Caching Laravel configuration, routes, and views..."
    php artisan config:cache || true
    php artisan route:cache || true
    php artisan view:cache || true
fi

echo "Sondhi Atelier starting on port ${PORT}..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
