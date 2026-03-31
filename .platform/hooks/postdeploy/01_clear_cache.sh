#!/bin/bash
set -e

cd /var/app/current

# Clear compiled/framework caches only — do NOT clear the application (Redis) cache
# or session data, which would log out all 9000 users on every deploy.
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Rebuild the caches immediately so the first request doesn't pay the cost
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Fix permissions
chown -R webapp:webapp storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

echo "Laravel caches cleared and rebuilt successfully!"
