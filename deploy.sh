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

# Jalankan migrate fresh dengan seeder (HANYA untuk setup awal, ganti setelah ada data production!)
$PHP_BIN artisan migrate:fresh --seed --force

# Clear optimize (cache, config, view, route, dll)
$PHP_BIN artisan optimize:clear
