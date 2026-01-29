#!/bin/bash
# Test Invoice Download Feature

cd "d:\PROJEK PROJEK\Ebook-Traveling"

# Check if route exists
echo "=== Checking Routes ==="
php artisan route:list | grep -i invoice

# Check if controller method exists
echo ""
echo "=== Checking Controller ==="
grep -n "public function download" app/Http/Controllers/InvoiceController.php

# Check if view exists
echo ""
echo "=== Checking Invoice View ==="
test -f "resources/views/invoices/payment-invoice.blade.php" && echo "✓ payment-invoice.blade.php exists" || echo "✗ payment-invoice.blade.php NOT found"

# Check DomPDF in composer
echo ""
echo "=== Checking DomPDF Dependency ==="
grep -i "barryvdh/laravel-dompdf" composer.json

# Check if GD extension is available
echo ""
echo "=== Checking PHP Extensions ==="
php -m | grep -i gd && echo "✓ GD extension found" || echo "✗ GD extension NOT found"

# Check storage permissions
echo ""
echo "=== Checking Storage Permissions ==="
ls -la storage/

# List recent payments
echo ""
echo "=== Checking Recent Payments in Database ==="
php artisan db:seed --seeder=PaymentSeeder 2>/dev/null || true

