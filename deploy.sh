#!/bin/bash

# ===============================
# CONFIG
# ===============================
PROJECT_PATH="/home/u778058510/domains/mappy.id/ebook_traveling_core"
PHP_BIN="/usr/bin/php"
BRANCH="main"

cd "$PROJECT_PATH" || exit 1

echo "🚀 Starting deployment (NO maintenance mode)"
echo "📅 $(date)"

# ===============================
# GIT UPDATE
# ===============================
echo "📥 Updating source code..."
/usr/bin/git fetch origin
/usr/bin/git reset --hard origin/$BRANCH

# ===============================
# IMMEDIATE FIX: Recreate storage directories after git reset
# ===============================
echo "📁 CRITICAL: Creating storage directories immediately..."
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/framework/cache
mkdir -p storage/framework/cache/data
mkdir -p storage/logs
mkdir -p storage/app/public
mkdir -p storage/app/public/ebook_covers
mkdir -p storage/app/public/subscription_banners
mkdir -p storage/app/public/users/avatars
mkdir -p storage/app/public/cities
mkdir -p bootstrap/cache

# CRITICAL: Set permissions immediately
echo "🔒 CRITICAL: Setting permissions immediately..."
chmod -R 777 storage
chmod -R 777 bootstrap/cache

echo "✅ Storage structure verified"

# ===============================
# COMPOSER
# ===============================
echo "📦 Installing composer dependencies..."
composer install \
  --no-dev \
  --optimize-autoloader \
  --no-interaction \
  || echo "⚠️ Composer failed, continuing..."

# ===============================
# CLEAR CACHE
# ===============================
echo "🧹 Clearing cache..."
$PHP_BIN artisan config:clear || true
$PHP_BIN artisan cache:clear || true
$PHP_BIN artisan route:clear || true
$PHP_BIN artisan view:clear || true

# ===============================
# MIGRATION
# ===============================
echo "🗄️ Running migrations..."
$PHP_BIN artisan migrate --force || echo "⚠️ Migration skipped"

# ===============================
# STORAGE LINK
# ===============================
echo "🔗 Creating storage symlink..."
rm -f public/storage 2>/dev/null || true
$PHP_BIN artisan storage:link || true

# Verify symlink
if [ -L "public/storage" ]; then
    echo "✅ Storage symlink created successfully"
else
    echo "⚠️ Storage symlink may have failed"
fi

# ===============================
# OPTIMIZE
# ===============================
echo "⚡ Optimizing..."
$PHP_BIN artisan config:cache || true
$PHP_BIN artisan route:cache || true
$PHP_BIN artisan view:cache || true

echo "✅ Deployment completed successfully"
echo "📅 $(date)"
