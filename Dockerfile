# ==========================================
# Stage 1: Frontend Build (Vite & Tailwind)
# ==========================================
FROM node:20-alpine AS node_builder

WORKDIR /app

# Copy dependency manifests
COPY package.json package-lock.json ./

# Install frontend dependencies
RUN npm ci

# Copy configuration and assets needed for Vite build
COPY vite.config.js ./
COPY resources ./resources
COPY public ./public
COPY legacy_static ./legacy_static

# Compile production assets (outputs to public/build and dist)
RUN npm run build


# ==========================================
# Stage 2: Production PHP-FPM + Nginx Runtime
# ==========================================
FROM php:8.4-fpm-alpine

WORKDIR /var/www/html

# Install system dependencies, Nginx, and Supervisor
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    git \
    unzip \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    icu-dev \
    sqlite-dev \
    oniguruma-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        pdo_sqlite \
        bcmath \
        exif \
        gd \
        intl \
        opcache \
        pcntl \
        zip

# Copy Composer binary from official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy configuration files
COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/php.ini /usr/local/etc/php/conf.d/custom.ini
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Copy Composer manifests for layer caching
COPY composer.json composer.lock ./

# Install backend dependencies without dev packages
RUN composer install --no-dev --no-interaction --no-scripts --prefer-dist --optimize-autoloader

# Copy application source code
COPY . .

# Copy compiled assets from node_builder stage
COPY --from=node_builder /app/public/build ./public/build
COPY --from=node_builder /app/dist ./dist

# Optimize composer autoloader for production
RUN composer dump-autoload --optimize --no-dev

# Prepare necessary storage directories and set permissions
RUN mkdir -p \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache \
    database \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Expose HTTP port (default 8000; dynamic $PORT supported by entrypoint)
EXPOSE 8000

ENV PORT=8000 \
    APP_ENV=production \
    APP_DEBUG=false

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
