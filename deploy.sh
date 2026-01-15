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
$PHP_BIN artisan db:seed --class=faqPageSeeder --force
$PHP_BIN artisan db:seed --class=PolicyPageSeeder --force
$PHP_BIN artisan db:seed --class=PaymentSeeder --force

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

