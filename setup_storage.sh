#!/bin/bash

# =====================================================
# Post-Deploy Setup Script
# =====================================================
# Script ini untuk setup storage symlink dan permission
# Jalankan SEKALI setelah first deploy atau jika ada masalah storage
# 
# Cara pakai:
# chmod +x setup_storage.sh
# ./setup_storage.sh
# =====================================================

# Colors for output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${YELLOW}=== Storage Setup Script ===${NC}\n"

# Path ke project
PROJECT_PATH="/home/u778058510/domains/mappy.id/ebook_traveling_core"
PHP_BIN="/usr/bin/php"

# Masuk ke folder project
cd $PROJECT_PATH || exit 1

echo -e "${YELLOW}1. Checking current storage symlink...${NC}"
if [ -L "public/storage" ]; then
    echo -e "${GREEN}✓ Symlink exists${NC}"
    ls -la public/storage
else
    echo -e "${RED}✗ Symlink not found${NC}"
fi

echo -e "\n${YELLOW}2. Removing old symlink (if exists)...${NC}"
rm -f public/storage
echo -e "${GREEN}✓ Done${NC}"

echo -e "\n${YELLOW}3. Creating new storage symlink...${NC}"
$PHP_BIN artisan storage:link
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Symlink created successfully${NC}"
else
    echo -e "${RED}✗ Failed to create symlink${NC}"
fi

echo -e "\n${YELLOW}4. Creating required directories...${NC}"
mkdir -p storage/app/public/ebook_covers
mkdir -p storage/app/public/subscription_banners
mkdir -p storage/app/public/users/avatars
mkdir -p storage/app/public/cities
echo -e "${GREEN}✓ Directories created${NC}"

echo -e "\n${YELLOW}5. Setting permissions...${NC}"
chmod -R 775 storage
chmod -R 775 bootstrap/cache
echo -e "${GREEN}✓ Permissions set to 775${NC}"

echo -e "\n${YELLOW}6. Setting ownership...${NC}"
# Sesuaikan dengan user hosting Anda
chown -R u778058510:u778058510 storage
chown -R u778058510:u778058510 bootstrap/cache
chown -R u778058510:u778058510 public/storage
echo -e "${GREEN}✓ Ownership set${NC}"

echo -e "\n${YELLOW}7. Verifying setup...${NC}"
echo "Storage symlink:"
ls -la public/storage

echo -e "\nStorage directories:"
ls -la storage/app/public/

echo -e "\nStorage permissions:"
ls -ld storage/app/public/

echo -e "\n${GREEN}=== Setup Complete! ===${NC}"
echo -e "\nTest upload gambar sekarang di admin panel."
echo -e "Jika masih error, cek:"
echo -e "  - File .env: APP_URL harus sesuai domain production"
echo -e "  - Browser console untuk error 404/403"
echo -e "  - Server error logs di storage/logs/laravel.log"
