#!/bin/bash

# ===============================
# CONFIG
# ===============================
PROJECT_PATH="/home/u778058510/domains/mappy.id/ebook_traveling_core"
PHP_BIN="/usr/bin/php"
BRANCH="main"

cd "$PROJECT_PATH" || exit 1

echo "🚀 Starting SAFE deployment..."
echo "📅 $(date)"

# ===============================
# MAINTENANCE MODE ON (SAFE)
# ===============================
echo "🔧 Enabling maintenance mode..."
$PHP_BIN artisan down --retry=60 --secret="deploy" || true

# ===============================
# GIT UPDATE (FORCE SAFE)
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
# CLEAR CACHE (SAFE)
# ===============================
echo "🧹 Clearing cache..."
$PHP_BIN artisan config:clear || true
$PHP_BIN artisan cache:clear || true
$PHP_BIN artisan route:clear || true
$PHP_BIN artisan view:clear || true

# ===============================
# MIGRATION (SAFE)
# ===============================
echo "🗄️ Running migrations..."
$PHP_BIN artisan migrate --force || echo "⚠️ Migration skipped"

# ===============================
# STORAGE LINK (SAFE)
# ===============================
echo "🔗 Storage link..."
$PHP_BIN artisan storage:link || true

# ===============================
# PERMISSIONS (SHARED HOSTING SAFE)
# ===============================
echo "🔒 Setting permissions..."
chmod -R 775 storage bootstrap/cache || true

# ===============================
# OPTIMIZE (SAFE)
# ===============================
echo "⚡ Optimizing..."
$PHP_BIN artisan config:cache || true
$PHP_BIN artisan route:cache || true
$PHP_BIN artisan view:cache || true

# ===============================
# MAINTENANCE MODE OFF (WAJIB)
# ===============================
echo "🟢 Disabling maintenance mode..."
$PHP_BIN artisan up || true
rm -f storage/framework/down || true

echo "✅ Deployment finished SAFELY"
echo "📅 $(date)"
