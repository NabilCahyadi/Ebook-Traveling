# MeatMap - Ebook Traveling Platform

Platform ebook digital untuk konten traveling & kuliner Indonesia.

## 📋 Daftar Isi

- [Requirements](#-requirements)
- [Installation](#-installation)
- [Production Deployment](#-production-deployment)
- [Environment Variables](#-environment-variables)
- [Seeder](#-seeder)
- [Admin Access](#-admin-access)
- [Payment Gateway](#-payment-gateway)
- [Troubleshooting](#-troubleshooting)

---

## 🔧 Requirements

- **PHP** >= 8.2
- **Composer** >= 2.0
- **Node.js** >= 18.x
- **NPM** >= 9.x
- **MySQL** >= 8.0 atau **MariaDB** >= 10.6
- **Redis** (opsional, direkomendasikan untuk production)

### PHP Extensions
```
BCMath, Ctype, cURL, DOM, Fileinfo, JSON, Mbstring, OpenSSL, PCRE, PDO, Tokenizer, XML, GD/Imagick
```

---

## 🚀 Installation

### Development

```bash
# Clone repository
git clone https://github.com/your-repo/meatmap.git
cd meatmap

# Install dependencies
composer install
npm install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Setup database
php artisan migrate

# Seed database (development with dummy data)
php artisan db:seed

# Build assets
npm run dev

# Start server
php artisan serve
```

---

## 🌐 Production Deployment

### Step 1: Server Preparation

```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install required packages
sudo apt install nginx mysql-server php8.2-fpm php8.2-mysql php8.2-mbstring php8.2-xml php8.2-bcmath php8.2-curl php8.2-gd php8.2-zip unzip git -y

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Node.js
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install -y nodejs
```

### Step 2: Clone & Setup Application

```bash
# Clone repository
cd /var/www
git clone https://github.com/your-repo/meatmap.git
cd meatmap

# Set permissions
sudo chown -R www-data:www-data /var/www/meatmap
sudo chmod -R 755 /var/www/meatmap
sudo chmod -R 775 /var/www/meatmap/storage
sudo chmod -R 775 /var/www/meatmap/bootstrap/cache

# Install dependencies (production mode)
composer install --optimize-autoloader --no-dev
npm install
npm run build
```

### Step 3: Environment Configuration

```bash
# Copy and edit environment file
cp .env.example .env
nano .env
```

**Wajib diubah:**
- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL=https://yourdomain.com`
- Database credentials
- Mail settings
- Google OAuth credentials
- Mayar API key (production)

### Step 4: Database Setup

```bash
# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate --force

# Seed PRODUCTION data only
php artisan db:seed --class=ProductionSeeder

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Step 5: Storage Link

```bash
php artisan storage:link
```

### Step 6: Queue Worker (Supervisor)

Buat file `/etc/supervisor/conf.d/meatmap-worker.conf`:

```ini
[program:meatmap-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/meatmap/artisan queue:work database --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/meatmap/storage/logs/worker.log
stopwaitsecs=3600
```

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start meatmap-worker:*
```

### Step 7: Scheduler (Cron Job)

```bash
crontab -e
```

Tambahkan:
```
* * * * * cd /var/www/meatmap && php artisan schedule:run >> /dev/null 2>&1
```

### Step 8: Nginx Configuration

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name yourdomain.com www.yourdomain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name yourdomain.com www.yourdomain.com;
    root /var/www/meatmap/public;

    ssl_certificate /etc/letsencrypt/live/yourdomain.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/yourdomain.com/privkey.pem;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    # Cache static files
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|pdf|woff|woff2)$ {
        expires 30d;
        add_header Cache-Control "public, immutable";
    }
}
```

```bash
sudo ln -s /etc/nginx/sites-available/meatmap /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### Step 9: SSL Certificate

```bash
sudo apt install certbot python3-certbot-nginx -y
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com
```

---

## 🔐 Environment Variables

### Wajib untuk Production

| Variable | Deskripsi | Contoh |
|----------|-----------|--------|
| `APP_ENV` | Environment aplikasi | `production` |
| `APP_DEBUG` | Mode debug | `false` |
| `APP_KEY` | Application key (auto-generate) | `base64:xxx...` |
| `APP_URL` | URL aplikasi | `https://yourdomain.com` |
| `DB_*` | Kredensial database | - |
| `MAIL_*` | Konfigurasi email SMTP | - |
| `GOOGLE_CLIENT_ID` | Google OAuth Client ID | - |
| `GOOGLE_CLIENT_SECRET` | Google OAuth Secret | - |
| `MAYAR_API_KEY` | API Key Mayar.id (production) | - |
| `MAYAR_ENVIRONMENT` | Environment Mayar | `production` |
| `MAYAR_WEBHOOK_TOKEN` | Webhook token untuk validasi | - |

### Opsional (Direkomendasikan)

| Variable | Deskripsi |
|----------|-----------|
| `SESSION_SECURE_COOKIE` | `true` untuk HTTPS |
| `SESSION_DOMAIN` | Domain untuk cookie |
| `CACHE_STORE` | `redis` untuk performa lebih baik |
| `QUEUE_CONNECTION` | `redis` untuk queue lebih cepat |

---

## 🌱 Seeder

### Production Seeder

Jalankan hanya seeder yang diperlukan untuk production:

```bash
php artisan db:seed --class=ProductionSeeder
```

**Seeder yang dijalankan:**
- ✅ RoleSeeder (Reader, Creator)
- ✅ AdminPermissionsSeeder
- ✅ PanelAccessPermissionSeeder
- ✅ SystemSettingSeeder
- ✅ DefaultAdminSeeder
- ✅ CategorySeeder
- ✅ CitySeeder
- ✅ CollectionSeeder
- ✅ SubscriptionPlanSeeder
- ✅ SubscriptionPromoSeeder
- ✅ LandingPageSectionsSeeder
- ✅ BannerSeeder
- ✅ PricingBannerSeeder
- ✅ PricingBenefitSeeder
- ✅ AboutUsSectionsSeeder
- ✅ ContactInfoSeeder
- ✅ SiteSettingsSeeder
- ✅ FaqSeeder, FaqPageSeeder, FaqPricingSeeder
- ✅ PolicyPageSeeder

**TIDAK termasuk:**
- ❌ UserSeeder (fake users)
- ❌ EbookSeeder (fake ebooks)
- ❌ BlogSeeder (fake blogs)
- ❌ PaymentSeeder (fake payments)
- ❌ TestBlogSeeder

### Development Seeder

Untuk development dengan dummy data:

```bash
php artisan db:seed
```

---

## 👤 Admin Access

Setelah menjalankan ProductionSeeder:

### Superadmin
- **Email:** `superadmin@gmail.com`
- **Password:** `123123123`
- **Akses:** Full access ke semua fitur

### Admin
- **Email:** `admin@gmail.com`
- **Password:** `123123123`
- **Akses:** Limited berdasarkan permission

⚠️ **PENTING:** Segera ganti password setelah login pertama!

### Ganti Password via Artisan

```bash
php artisan tinker
```

```php
$admin = \App\Models\Admin::where('email', 'superadmin@gmail.com')->first();
$admin->password = \Hash::make('password_baru_yang_kuat');
$admin->save();
```

---

## 💳 Payment Gateway (Mayar.id)

### Konfigurasi

1. Daftar di [Mayar.id](https://mayar.id)
2. Dapatkan API Key dari dashboard Mayar
3. Set environment variables:

```env
MAYAR_API_KEY=your_production_api_key
MAYAR_ENVIRONMENT=production
MAYAR_WEBHOOK_TOKEN=your_webhook_token
MAYAR_CALLBACK_URL=https://yourdomain.com/api/mayar/callback
MAYAR_RETURN_URL=https://yourdomain.com/payment/success
```

### Webhook Setup

Di dashboard Mayar, set webhook URL:
```
https://yourdomain.com/api/mayar/callback
```

### Payment Links

Update payment links di SubscriptionPlanSeeder sesuai dengan link dari Mayar dashboard:

```php
'mayar_payment_link' => 'https://yourdomain.myr.id/pl/plan-slug',
```

---

## 🔧 Troubleshooting

### Storage Permission Error

```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

### 500 Internal Server Error

```bash
# Check logs
tail -f storage/logs/laravel.log

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### Session/Login Issues

```bash
php artisan session:table
php artisan migrate
php artisan config:cache
```

### Queue Not Processing

```bash
# Check supervisor status
sudo supervisorctl status

# Restart workers
sudo supervisorctl restart meatmap-worker:*

# Manual test
php artisan queue:work --once
```

### Assets Not Loading (Vite)

```bash
npm run build
php artisan view:clear
```

---

## 📞 Support

Jika ada pertanyaan atau masalah, hubungi tim development.

---

## 📄 License

Proprietary - All rights reserved.
