#!/bin/bash
# Ensure phpredis extension is available for Valkey/ElastiCache TLS connection
# Production: myportal.pps.org.ph (Valkey Serverless via RDS Proxy)
# Dev: dev.myportal.pps.org.ph (direct RDS PostgreSQL, same Valkey cluster)
# Runs as root during EB prebuild phase on Amazon Linux 2023

set -e

if ! php -m | grep -q "^redis$"; then
    echo "phpredis not found, attempting install..."
    dnf install -y php8.2-php-pecl-redis || true
fi

echo "phpredis status: $(php -m | grep redis || echo 'not loaded')"
