<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Payment;

// Get first successful payment
$payment = Payment::where('status', 'success')->with('user', 'plan', 'subscription')->first();

if ($payment) {
    echo "✓ Found payment:\n";
    echo "  - ID: {$payment->id}\n";
    echo "  - Amount: Rp " . number_format($payment->amount, 0, ',', '.') . "\n";
    echo "  - Status: {$payment->status}\n";
    echo "  - User: {$payment->user->name}\n";
    echo "  - Plan: " . ($payment->plan ? $payment->plan->name : 'N/A') . "\n";
    echo "  - Payment Code: {$payment->payment_code}\n";
    echo "\nTest download URL:\n";
    echo "  GET /user/invoice/{$payment->id}/download\n";
    echo "  Route name: user.invoice.download\n";
    echo "\nExpected filename: Invoice-{$payment->payment_code}-" . date('Ymd') . ".pdf\n";
} else {
    echo "✗ No successful payment found in database\n";
}
