#!/bin/bash

# Path ke project
PROJECT_PATH="/home/u778058510/domains/mappy.id/ebook_traveling_core"

# Path ke PHP (ubah jika hosting berbeda)
PHP_BIN="/usr/bin/php"

# Masuk ke folder project
cd $PROJECT_PATH

echo "🚀 Starting deployment process..."

# Update repo dari GitHub
echo "📥 Pulling latest changes from repository..."
/usr/bin/git fetch --all    
/usr/bin/git reset --hard origin/main
/usr/bin/git pull origin main

# Install/Update dependencies
echo "📦 Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# Install NPM dependencies and build assets
echo "🎨 Building frontend assets..."
npm install --production
npm run build

# Clear all caches before migration
echo "🧹 Clearing application cache..."
$PHP_BIN artisan config:clear
$PHP_BIN artisan cache:clear
$PHP_BIN artisan view:clear
$PHP_BIN artisan route:clear

# Jalankan migration (tanpa fresh untuk preserve data)
echo "🗄️  Running migrations..."
$PHP_BIN artisan migrate --force

# Run seeders untuk update data yang diperlukan (tanpa hapus data existing)
echo "🌱 Running necessary seeders..."

# Create storage symlink (PENTING untuk akses file dari public)
echo "🔗 Creating storage symbolic link..."
$PHP_BIN artisan storage:link

# Set permissions untuk storage dan cache
echo "🔒 Setting proper permissions..."
chmod -R 775 storage bootstrap/cache
chown -R $USER:$USER storage bootstrap/cache

# Optimize application for production
echo "⚡ Optimizing application..."
$PHP_BIN artisan config:cache
$PHP_BIN artisan route:cache
$PHP_BIN artisan view:cache

# Force browser cache refresh by updating file timestamps
echo "🔄 Updating static file timestamps..."
touch public/assets/admin/vendor/css/rtl/theme-default.css
touch public/assets/admin/vendor/css/theme-default.css

# Update version timestamp for cache busting
echo "📌 Updating app version for cache busting..."
TIMESTAMP=$(date +%s)
sed -i "s/APP_VERSION=.*/APP_VERSION=$TIMESTAMP/" .env 2>/dev/null || echo "APP_VERSION=$TIMESTAMP" >> .env

echo "✅ Deployment completed successfully!"
echo "⚠️  Note: Clear your browser cache (Ctrl+Shift+R) to see latest changes"
echo "📝 Deployment timestamp: $(date)"
echo "🔖 App version: $TIMESTAMP"
