<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Payment;
use Illuminate\Support\Facades\View;

$payment = Payment::where('status', 'success')->first();
if (! $payment) {
    echo "No success payment found\n";
    exit(1);
}

// Prepare data
$payment->load('user', 'plan', 'subscription');
$data = [
    'payment' => $payment,
    'user' => $payment->user,
    'plan' => $payment->plan,
    'subscription' => $payment->subscription,
    'invoiceDate' => $payment->created_at,
    'invoiceNumber' => $payment->payment_code,
    'dueDate' => $payment->expired_at ?? $payment->created_at->addDays(7),
];

// Try to render the view
try {
    $html = View::make('invoices.payment-invoice', $data)->render();
    echo "✓ View rendered successfully!\n";
    echo "HTML length: " . strlen($html) . " bytes\n";

    // Check if view has content
    if (strlen($html) < 100) {
        echo "⚠ Warning: View HTML is very short\n";
        echo "Content: " . substr($html, 0, 200) . "\n";
    } else {
        echo "✓ View content looks normal\n";
    }
} catch (\Exception $e) {
    echo "❌ View render error:\n";
    echo $e->getMessage() . "\n";
    echo "\nFull trace:\n";
    echo $e->getTraceAsString() . "\n";
}
