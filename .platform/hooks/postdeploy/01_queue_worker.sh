#!/bin/bash
# Restart Laravel queue worker after each deployment
# Applies to both production (myportal.pps.org.ph) and dev (dev.myportal.pps.org.ph)
# Queue uses Redis DB 3 (REDIS_QUEUE_DB=3) with prefix pps_portal_
# Runs as root during EB postdeploy phase

set -e

APP_DIR=/var/app/current

if [ -f "$APP_DIR/artisan" ]; then
    echo "Restarting queue workers..."
    sudo -u webapp php "$APP_DIR/artisan" queue:restart
    echo "Queue workers restarted successfully."
else
    echo "artisan not found at $APP_DIR, skipping queue restart."
fi
