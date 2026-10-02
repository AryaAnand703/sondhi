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

# Ensure .env exists in container (not copied by Docker due to .dockerignore)
if [ ! -f /var/www/html/.env ]; then
    echo "Creating .env file from .env.example..."
    if [ -f /var/www/html/.env.example ]; then
        cp /var/www/html/.env.example /var/www/html/.env
    else
        touch /var/www/html/.env
    fi
fi

# Ensure PHP-FPM preserves environment variables passed by Render
for fpm_conf in /usr/local/etc/php-fpm.d/www.conf /etc/php84/php-fpm.d/www.conf /etc/php/8.4/fpm/pool.d/www.conf; do
    if [ -f "$fpm_conf" ]; then
        sed -i 's/;*clear_env = .*/clear_env = no/g' "$fpm_conf" || true
    fi
done

# Ensure correct database directory and file permissions
DB_FILE="${DB_DATABASE:-/var/www/html/database/database.sqlite}"
if [ "$DB_CONNECTION" = "sqlite" ] || [ -z "$DB_CONNECTION" ]; then
    export DB_CONNECTION=sqlite
    export DB_DATABASE="$DB_FILE"
    sed -i "s|^DB_CONNECTION=.*|DB_CONNECTION=sqlite|" /var/www/html/.env || true
    sed -i "s|^DB_DATABASE=.*|DB_DATABASE=${DB_FILE}|" /var/www/html/.env || true
    if [ ! -f "$DB_FILE" ]; then
        echo "Initializing SQLite database file at ${DB_FILE}..."
        touch "$DB_FILE"
    fi
fi

# Ensure full write permissions for web server on storage, cache, database, and .env
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database /var/www/html/.env
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 777 /var/www/html/database
if [ -f "$DB_FILE" ]; then
    chmod 666 "$DB_FILE"
fi

# Generate APP_KEY if missing
if [ -z "$APP_KEY" ]; then
    EXISTING_KEY=$(grep '^APP_KEY=' /var/www/html/.env 2>/dev/null | cut -d '=' -f2- || true)
    if [ -z "$EXISTING_KEY" ] || [ "$EXISTING_KEY" = "" ]; then
        echo "APP_KEY is not set. Generating application key..."
        GEN_KEY=$(php artisan key:generate --show --no-ansi)
        export APP_KEY="$GEN_KEY"
        sed -i "s|^APP_KEY=.*|APP_KEY=${GEN_KEY}|" /var/www/html/.env || echo "APP_KEY=${GEN_KEY}" >> /var/www/html/.env
    else
        export APP_KEY="$EXISTING_KEY"
    fi
else
    sed -i "s|^APP_KEY=.*|APP_KEY=${APP_KEY}|" /var/www/html/.env || echo "APP_KEY=${APP_KEY}" >> /var/www/html/.env
fi

# Forward optional environment secrets into .env for PHP workers
[ -n "$TWILIO_SID" ] && sed -i "s|^TWILIO_SID=.*|TWILIO_SID=${TWILIO_SID}|" /var/www/html/.env || true
[ -n "$TWILIO_AUTH_TOKEN" ] && sed -i "s|^TWILIO_AUTH_TOKEN=.*|TWILIO_AUTH_TOKEN=${TWILIO_AUTH_TOKEN}|" /var/www/html/.env || true
[ -n "$TWILIO_NUMBER" ] && sed -i "s|^TWILIO_NUMBER=.*|TWILIO_NUMBER=${TWILIO_NUMBER}|" /var/www/html/.env || true
[ -n "$TWILIO_VERIFY_SID" ] && sed -i "s|^TWILIO_VERIFY_SID=.*|TWILIO_VERIFY_SID=${TWILIO_VERIFY_SID}|" /var/www/html/.env || true

# Run database migrations and seeders so catalog and users exist
echo "Running database migrations..."
php artisan migrate --force || true

echo "Seeding database with default products and catalogue..."
php artisan db:seed --force || true

# Clear cached config first to load new APP_KEY and database settings
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Production cache optimization
if [ "$APP_ENV" = "production" ]; then
    echo "Caching Laravel configuration, routes, and views..."
    php artisan config:cache || true
    php artisan route:cache || true
    php artisan view:cache || true
fi

echo "Sondhi Atelier starting on port ${PORT}..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
