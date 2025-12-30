#!/bin/bash

# Path ke project
PROJECT_PATH="/home/u778058510/domains/mappy.id/ebook_traveling_core"

# Path ke PHP (ubah jika hosting berbeda)
PHP_BIN="/usr/bin/php"

# Masuk ke folder project
cd $PROJECT_PATH

# Update repo dari GitHub
/usr/bin/git fetch --all    
/usr/bin/git reset --hard origin/main

# Install/Update dependencies
composer install --no-dev --optimize-autoloader --no-interaction

# Clear all caches before migration
$PHP_BIN artisan config:clear
$PHP_BIN artisan cache:clear
$PHP_BIN artisan view:clear
$PHP_BIN artisan route:clear

# Jalankan migrate:fresh dengan semua seeder
$PHP_BIN artisan migrate --force
$PHP_BIN artisan db:seed --class=UpdateBlogCategoriesSeeder --force

# Create storage symlink (PENTING untuk akses file dari public)
$PHP_BIN artisan storage:link

# Set permissions untuk storage dan cache
chmod -R 775 storage bootstrap/cache
chown -R $USER:$USER storage bootstrap/cache

# Optimize application for production
$PHP_BIN artisan config:cache
$PHP_BIN artisan route:cache
$PHP_BIN artisan view:cache
