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

# PENTING: Hapus vendor folder lama sebelum install ulang
echo "🧹 Removing old vendor folder..."
rm -rf vendor
rm -rf composer.lock

# Install/Update dependencies - DENGAN AUTOLOADER
echo "📦 Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Generate autoloader cache
echo "⚙️  Generating Composer autoloader..."
composer dump-autoload --optimize

# Clear all caches before migration
echo "🧹 Clearing application cache..."
$PHP_BIN artisan config:clear
$PHP_BIN artisan cache:clear
$PHP_BIN artisan view:clear
$PHP_BIN artisan route:clear

# Jalankan migrate
echo "🗄️  Running migrations..."
$PHP_BIN artisan migrate --force

# Create storage symlink (PENTING untuk akses file dari public)
echo "🔗 Creating storage symbolic link..."
$PHP_BIN artisan storage:link

# Ensure all storage directories exist
echo "📁 Creating storage directories..."
mkdir -p storage/framework/sessions
mkdir -p storage/framework/cache
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p storage/app/public

# Set permissions untuk storage dan cache
echo "🔒 Setting proper permissions..."
chmod -R 775 storage bootstrap/cache
chown -R u778058510:u778058510 storage bootstrap/cache

# Optimize application for production
echo "⚡ Optimizing application..."
$PHP_BIN artisan config:cache
$PHP_BIN artisan route:cache
$PHP_BIN artisan view:cache

# Test autoload
echo "✅ Testing ServiceProvider autoload..."
$PHP_BIN artisan tinker --execute="echo 'ServiceProviders loaded successfully';"

echo "✅ Deployment completed successfully!"
