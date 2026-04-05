#!/bin/bash
# Clear and rebuild Laravel config/route/view cache after every deployment
# This prevents stale config cache from serving wrong env var values
# Critical for both production (myportal.pps.org.ph) and dev (dev.myportal.pps.org.ph)
# Runs as root during EB postdeploy phase on Amazon Linux 2023

set -e

APP_DIR=/var/app/current

if [ -f "$APP_DIR/artisan" ]; then
    echo "Clearing Laravel caches post-deploy..."
    sudo -u webapp php "$APP_DIR/artisan" config:clear
    sudo -u webapp php "$APP_DIR/artisan" route:clear
    sudo -u webapp php "$APP_DIR/artisan" view:clear
    sudo -u webapp php "$APP_DIR/artisan" config:cache
    echo "Laravel caches cleared and rebuilt successfully."
else
    echo "artisan not found at $APP_DIR, skipping cache operations."
fi
