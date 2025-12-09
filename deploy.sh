#!/bin/bash

# Masuk ke folder project
cd /home/u778058510/domains/mappy.id/ebook_traveling_core

# Update repo
/usr/bin/git fetch --all
/usr/bin/git reset --hard origin/main

# Jalankan migrate fresh + seeder
/usr/bin/php artisan migrate:fresh --seed
