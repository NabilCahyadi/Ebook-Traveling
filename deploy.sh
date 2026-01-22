PROJECT="/home/u778058510/domains/mappy.id/ebook_traveling_core"
PHP="/usr/bin/php"

cd "$PROJECT" || exit 1

echo "🚀 Deploy started: $(date)"

$PHP artisan down || true

git fetch origin
git reset --hard origin/main

composer install --no-dev --optimize-autoloader --no-interaction

$PHP artisan optimize:clear

$PHP artisan migrate --force

$PHP artisan storage:link || true

chmod -R 775 storage bootstrap/cache

$PHP artisan optimize

$PHP artisan up

echo "✅ Deploy finished: $(date)"
