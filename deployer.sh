#!/bin/bash
set -e

echo "Deployment started ..."

# Check if maintenance mode is already enabled
if php artisan down --check > /dev/null 2>&1; then
    MAINTENANCE_MODE_ENABLED=true
else
    MAINTENANCE_MODE_ENABLED=false
fi

# Enable maintenance mode if not already enabled
if [ "$MAINTENANCE_MODE_ENABLED" = false ]; then
    php artisan down
fi

# Allow Composer to run with superuser privileges
export COMPOSER_ALLOW_SUPERUSER=1

# Switch to the desired branch (e.g., "main" or "develop")
git checkout master

# Pull the latest version of the desired branch
git pull origin master

# Install dependencies
composer install --ignore-platform-reqs --no-scripts --prefer-dist --no-dev --no-interaction

# Clear Composer's cache
composer clear-cache

# Regenerate the autoloader
composer dump-autoload

# Run database migrations (uncomment this section if needed)
# php artisan migrate --force

# Disable maintenance mode if it was not enabled before
if [ "$MAINTENANCE_MODE_ENABLED" = false ]; then
    php artisan up
fi

echo "Deployment finished!"
