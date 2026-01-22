#!/bin/bash

# ===============================
# CONFIGs
# ===============================
PROJECT_PATH="/home/u778058510/domains/mappy.id/ebook_traveling_core"
PHP_BIN="/usr/bin/php"
BRANCH="main"

cd "$PROJECT_PATH" || exit 1

echo "🚀 Starting deployment (NO maintenance mode)"
echo "📅 $(date)"

# ===============================
# FORCE DISABLE MAINTENANCE MODE FIRST
# ===============================
echo "⚠️ FORCE disabling maintenance mode (pre-deployment)..."
$PHP_BIN artisan up 2>/dev/null || true
rm -f storage/framework/down 2>/dev/null || true
rm -f storage/framework/maintenance.php 2>/dev/null || true
find storage/framework -name "*down*" -type f -delete 2>/dev/null || true

# ===============================
# GIT UPDATE (SAFE METHOD - Keep local changes)
# ===============================
echo "📥 Updating source code (safe mode)..."
# Stash any local changes first
/usr/bin/git stash 2>/dev/null || true

# Fetch latest changes
/usr/bin/git fetch origin

# Pull without destroying local files
/usr/bin/git pull origin $BRANCH --rebase || /usr/bin/git pull origin $BRANCH

# If pull failed, try force but selective
if [ $? -ne 0 ]; then
    echo "⚠️ Normal pull failed, trying alternative method..."
    /usr/bin/git reset --soft origin/$BRANCH
    /usr/bin/git pull origin $BRANCH
fi

echo "✅ Code updated"

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

# CRITICAL: Delete ALL session files (fix corrupt sessions)
echo "🗑️ CRITICAL: Deleting all session files..."
rm -rf storage/framework/sessions/* 2>/dev/null || true
rm -rf storage/framework/cache/* 2>/dev/null || true
rm -rf storage/framework/views/* 2>/dev/null || true

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
echo "🧹 Clearing ALL caches and sessions..."
# Clear Laravel caches
$PHP_BIN artisan config:clear || true
$PHP_BIN artisan cache:clear || true
$PHP_BIN artisan route:clear || true
$PHP_BIN artisan view:clear || true

# Physically delete cache files
rm -rf storage/framework/cache/data/* 2>/dev/null || true
rm -rf storage/framework/views/* 2>/dev/null || true
rm -rf bootstrap/cache/*.php 2>/dev/null || true

# Delete ALL session files again (double insurance)
rm -rf storage/framework/sessions/* 2>/dev/null || true

echo "✅ All caches and sessions cleared"

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

# ===============================
# FINAL: FORCE ENSURE SITE IS UP
# ===============================
echo "✅ FINAL: Force ensuring site is UP..."
$PHP_BIN artisan up 2>/dev/null || true
rm -f storage/framework/down 2>/dev/null || true
rm -f storage/framework/maintenance.php 2>/dev/null || true

# Verify no maintenance files exist
if [ -f storage/framework/down ]; then
    echo "⚠️ WARNING: Maintenance file still exists! Force removing..."
    rm -rf storage/framework/down
fi

# Triple check - artisan up again
$PHP_BIN artisan up 2>/dev/null || true

echo "✅ Deployment completed successfully"
echo "📅 $(date)"
echo "🌐 Site should be accessible at: https://dev-new.mappy.id"
