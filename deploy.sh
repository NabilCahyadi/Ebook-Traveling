#!/bin/bash

# Path ke project
PROJECT_PATH="/home/u778058510/domains/mappy.id/ebook_traveling_core"

# Path ke PHP (ubah jika hosting berbeda)
PHP_BIN="/usr/bin/php"

# Masuk ke folder project
cd $PROJECT_PATH

echo "🚀 Starting deployment process..."
echo "📅 Timestamp: $(date)"

# CRITICAL: Force disable maintenance mode FIRST
echo "✅ Force disabling maintenance mode..."
$PHP_BIN artisan up 2>/dev/null || true
rm -f storage/framework/down 2>/dev/null || true

# Update repo dari GitHub
echo "📥 Pulling latest changes from repository..."
/usr/bin/git fetch --all    
/usr/bin/git reset --hard origin/main
/usr/bin/git pull origin main

# Install/Update dependencies
echo "📦 Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction 2>/dev/null || composer install --no-dev --no-interaction

# Clear all caches
echo "🧹 Clearing all caches..."
$PHP_BIN artisan cache:clear 2>/dev/null || true
$PHP_BIN artisan config:clear 2>/dev/null || true
$PHP_BIN artisan view:clear 2>/dev/null || true
$PHP_BIN artisan route:clear 2>/dev/null || true

# Remove bootstrap cache files
echo "🧹 Clearing bootstrap cache..."
rm -rf bootstrap/cache/*.php 2>/dev/null || true

# Jalankan migration (tanpa fresh untuk preserve data)
echo "🗄️  Running migrations..."
$PHP_BIN artisan migrate --force 2>/dev/null || echo "⚠️ Migration skipped"

# Create storage symlink (PENTING untuk akses file dari public)
echo "🔗 Creating storage symbolic link..."
$PHP_BIN artisan storage:link 2>/dev/null || true

# Set permissions untuk storage dan cache
echo "🔒 Setting proper permissions..."
chmod -R 775 storage bootstrap/cache 2>/dev/null || true

# Regenerate composer autoload
echo "🔄 Regenerating autoload..."
composer dump-autoload --optimize 2>/dev/null || true

# Optimize application for production
echo "⚡ Optimizing application..."
$PHP_BIN artisan config:cache 2>/dev/null || true
$PHP_BIN artisan route:cache 2>/dev/null || true
$PHP_BIN artisan view:cache 2>/dev/null || true

# Force browser cache refresh by updating file timestamps
echo "🔄 Updating static file timestamps..."
touch public/assets/admin/vendor/css/rtl/theme-default.css 2>/dev/null || true
touch public/assets/admin/vendor/css/theme-default.css 2>/dev/null || true

# FINAL: Ensure maintenance mode is OFF
echo "✅ Final check - ensuring site is UP..."
$PHP_BIN artisan up 2>/dev/null || true

echo ""
echo "✅ Deployment completed!"
echo "📝 Note: Clear browser cache (Ctrl+Shift+R) to see changes"
echo "🌐 Site: https://dev-new.mappy.id"
echo ""
echo ""

