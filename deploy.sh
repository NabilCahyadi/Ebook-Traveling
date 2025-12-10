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

# Install/Update dependencies (optional, uncomment jika perlu)
# composer install --no-dev --optimize-autoloader

# Jalankan migrate (HANYA untuk setup awal, ganti setelah ada data production!)
$PHP_BIN artisan migrate --force

# Create storage symlink (PENTING untuk akses file dari public)
$PHP_BIN artisan storage:link

# Set permissions untuk storage dan cache
chmod -R 775 storage bootstrap/cache
chown -R $USER:$USER storage bootstrap/cache

# Clear optimize (cache, config, view, route, dll)
$PHP_BIN artisan optimize:clear

# Cache config dan routes untuk performance
$PHP_BIN artisan config:cache
$PHP_BIN artisan route:cache
$PHP_BIN artisan view:cache
