#!/bin/bash

# =====================================
# IMPROVED DEPLOYMENT SCRIPT
# =====================================

# Path ke project
PROJECT_PATH="/home/u778058510/domains/mappy.id/ebook_traveling_core"
PHP_BIN="/usr/bin/php"
BACKUP_DIR="$PROJECT_PATH/../backups"
TIMESTAMP=$(date +%Y%m%d_%H%M%S)

# Masuk ke folder project
cd $PROJECT_PATH

# =====================================
# ROLLBACK FUNCTION
# =====================================
rollback() {
    echo "❌ Deployment failed! Rolling back..."
    /usr/bin/git reset --hard HEAD@{1}
    composer install --no-dev --optimize-autoloader --no-interaction
    $PHP_BIN artisan cache:clear
    $PHP_BIN artisan config:cache
    $PHP_BIN artisan up
    echo "⚠️ Rollback completed. Check logs for details."
    exit 1
}

# Set error handler
set -e
trap rollback ERR

echo "=================================="
echo "🚀 DEPLOYMENT STARTED"
echo "=================================="
echo "📅 Timestamp: $(date)"
echo ""

# =====================================
# 1. BACKUP DATABASE
# =====================================
echo "💾 Creating database backup..."
mkdir -p $BACKUP_DIR
mysqldump -u DB_USER -pDB_PASS DB_NAME > "$BACKUP_DIR/db_backup_$TIMESTAMP.sql" 2>/dev/null || echo "⚠️ Backup skipped"

# =====================================
# 2. MAINTENANCE MODE ON
# =====================================
echo "🔧 Enabling maintenance mode..."
$PHP_BIN artisan down --retry=60 --secret="deploy-secret-$TIMESTAMP" || true

# =====================================
# 3. PULL LATEST CODE
# =====================================
echo "📥 Pulling latest changes from repository..."
/usr/bin/git fetch --all    
/usr/bin/git reset --hard origin/main
/usr/bin/git pull origin main

# =====================================
# 4. INSTALL DEPENDENCIES
# =====================================
echo "📦 Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

echo "📦 Installing NPM dependencies..."
npm ci --production 2>/dev/null || npm install --production

# =====================================
# 5. BUILD ASSETS
# =====================================
echo "🎨 Building frontend assets..."
npm run build

# =====================================
# 6. CLEAR CACHES
# =====================================
echo "🧹 Clearing application cache..."
$PHP_BIN artisan config:clear
$PHP_BIN artisan cache:clear
$PHP_BIN artisan view:clear
$PHP_BIN artisan route:clear

# =====================================
# 7. RUN MIGRATIONS
# =====================================
echo "🗄️  Running migrations..."
$PHP_BIN artisan migrate --force

# =====================================
# 8. STORAGE LINK & PERMISSIONS
# =====================================
echo "🔗 Creating storage symbolic link..."
$PHP_BIN artisan storage:link 2>/dev/null || echo "Storage link already exists"

echo "🔒 Setting proper permissions..."
chmod -R 775 storage bootstrap/cache
chown -R $USER:$USER storage bootstrap/cache 2>/dev/null || true

# =====================================
# 9. OPTIMIZE FOR PRODUCTION
# =====================================
echo "⚡ Optimizing application..."
$PHP_BIN artisan config:cache
$PHP_BIN artisan route:cache
$PHP_BIN artisan view:cache

# =====================================
# 10. CACHE BUSTING
# =====================================
echo "🔄 Updating static file timestamps..."
find public/assets -type f -name "*.css" -exec touch {} \; 2>/dev/null || true
find public/assets -type f -name "*.js" -exec touch {} \; 2>/dev/null || true

echo "📌 Updating app version..."
APP_VERSION=$(date +%s)
sed -i "s/APP_VERSION=.*/APP_VERSION=$APP_VERSION/" .env 2>/dev/null || echo "APP_VERSION=$APP_VERSION" >> .env

# =====================================
# 11. MAINTENANCE MODE OFF
# =====================================
echo "✅ Disabling maintenance mode..."
$PHP_BIN artisan up

# =====================================
# 12. HEALTH CHECK
# =====================================
echo "🏥 Running health check..."
sleep 2
HTTP_CODE=$(curl -o /dev/null -s -w "%{http_code}\n" https://mappy.id 2>/dev/null || echo "000")
if [ "$HTTP_CODE" -eq 200 ]; then
    echo "✅ Health check passed (HTTP $HTTP_CODE)"
else
    echo "⚠️  Health check warning (HTTP $HTTP_CODE)"
fi

# Remove error handler
set +e
trap - ERR

# =====================================
# DEPLOYMENT SUMMARY
# =====================================
echo ""
echo "=================================="
echo "✅ DEPLOYMENT COMPLETED"
echo "=================================="
echo "📝 Timestamp: $(date)"
echo "🔖 App version: $APP_VERSION"
echo "💾 DB backup: db_backup_$TIMESTAMP.sql"
echo "🌐 Site status: HTTP $HTTP_CODE"
echo ""
echo "⚠️  IMPORTANT:"
echo "   - Clear browser cache (Ctrl+Shift+R)"
echo "   - Verify changes on production"
echo "   - Monitor error logs"
echo "=================================="
