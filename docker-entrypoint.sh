#!/bin/bash
set -e

# Copy .env if it exists (Render injects env vars directly)
if [ -f .env.example ] && [ ! -f .env ]; then
    cp .env.example .env
fi

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Clear stale caches
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Cache for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
php artisan migrate --force || true

# Storage symlink
php artisan storage:link || true

# Start Apache
exec "$@"