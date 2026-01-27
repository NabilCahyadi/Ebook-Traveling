#!/bin/bash

PROJECT_PATH="/home/u778058510/domains/mappy.id/ebook_traveling_core"
PHP_BIN="/usr/bin/php"

cd $PROJECT_PATH || exit

echo "🚀 Deploying..."

# Update code
git fetch --all
git reset --hard origin/main

# Install dependencies
composer install --no-dev --optimize-autoloader --no-interaction

# Clear everything safely
$PHP_BIN artisan optimize:clear

# Run migrations
$PHP_BIN artisan migrate --force

# Storage link
$PHP_BIN artisan storage:link

# Ensure all storage directories exist
echo "📁 Creating storage directories..."
mkdir -p storage/framework/sessions
mkdir -p storage/framework/cache
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p storage/app/public

# Permissions (SAFE)
chmod -R 775 storage bootstrap/cache

echo "✅ Deploy finished"
