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
# COMPOSER
# ===============================
echo "📦 Installing composer dependencies..."
composer install \
  --no-dev \
  --optimize-autoloader \
  --no-interaction \
  || echo "⚠️ Composer failed, continuing..."

# ===============================
# ENSURE STORAGE DIRECTORIES (🔥 FIX UTAMA)
# ===============================
echo "📁 Ensuring Laravel storage directories..."
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/framework/cache
mkdir -p storage/logs

# ===============================
# PERMISSIONS (SAFE)
# ===============================
echo "🔒 Fixing permissions..."
chmod -R 775 storage bootstrap/cache || true

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
echo "🔗 Storage link..."
$PHP_BIN artisan storage:link || true

# ===============================
# OPTIMIZE
# ===============================
echo "⚡ Optimizing..."
$PHP_BIN artisan config:cache || true
$PHP_BIN artisan route:cache || true
$PHP_BIN artisan view:cache || true

echo "✅ Deployment completed successfully"
echo "📅 $(date)"
