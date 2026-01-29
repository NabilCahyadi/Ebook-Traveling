<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;

echo "=== Invoice Download Test ===\n\n";

// Get first successful payment
$payment = Payment::where('status', 'success')
    ->with('user', 'plan', 'subscription')
    ->first();

if (!$payment) {
    echo "✗ No successful payment found\n";
    exit(1);
}

echo "✓ Found payment:\n";
echo "  - ID: {$payment->id}\n";
echo "  - User: {$payment->user->name}\n";
echo "  - Plan: " . ($payment->plan ? $payment->plan->name : 'N/A') . "\n";
echo "  - Amount: Rp " . number_format($payment->amount, 0, ',', '.') . "\n";
echo "  - Status: {$payment->status}\n\n";

// Try to generate PDF
echo "Attempting to load invoice view...\n";
try {
    $data = [
        'payment' => $payment,
        'user' => $payment->user,
        'plan' => $payment->plan,
        'subscription' => $payment->subscription,
        'invoiceDate' => $payment->created_at,
        'invoiceNumber' => $payment->payment_code,
        'dueDate' => $payment->expired_at ?? $payment->created_at->addDays(7),
    ];

    echo "Data prepared:\n";
    echo "  - invoiceNumber: {$data['invoiceNumber']}\n";
    echo "  - invoiceDate: {$data['invoiceDate']}\n";

    echo "\nLoading view: invoices.payment-invoice\n";
    $pdf = Pdf::loadView('invoices.payment-invoice', $data);

    echo "✓ PDF loaded successfully\n";

    $filename = 'Invoice-' . $payment->payment_code . '-' . date('Ymd') . '.pdf';
    echo "✓ Filename: {$filename}\n";

    // Try to output to temp file instead of download
    $tempFile = storage_path('app/temp-invoice.pdf');
    $pdf->save($tempFile);

    if (file_exists($tempFile)) {
        $size = filesize($tempFile);
        echo "✓ PDF saved successfully to: {$tempFile}\n";
        echo "  File size: " . number_format($size, 0) . " bytes\n";

        // Clean up
        unlink($tempFile);
        echo "✓ Temp file cleaned up\n";
    } else {
        echo "✗ PDF save failed\n";
    }

} catch (\Exception $e) {
    echo "✗ ERROR: " . $e->getMessage() . "\n";
    echo "Trace:\n";
    echo $e->getTraceAsString() . "\n";
}
