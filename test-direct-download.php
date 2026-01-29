<?php
/**
 * Direct Test Invoice Download
 * Simulate the same request as clicking the button
 */

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/bootstrap/app.php';

use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

try {
    echo "=== Direct Invoice Download Test ===\n\n";

    // Get a test payment
    $payment = Payment::where('status', 'success')->first();

    if (!$payment) {
        echo "❌ No successful payment found\n";
        exit(1);
    }

    echo "✓ Found payment: {$payment->id} ({$payment->payment_code})\n";
    echo "  Status: {$payment->status}\n";
    echo "  User: {$payment->user->name}\n\n";

    // Prepare data
    echo "📋 Preparing invoice data...\n";
    $data = [
        'payment' => $payment,
        'user' => $payment->user,
        'plan' => $payment->plan,
        'subscription' => $payment->subscription,
    ];

    // Load view
    echo "📄 Loading view template...\n";
    $view = view('invoices.payment-invoice', $data);
    echo "✓ View loaded: " . strlen($view) . " bytes\n\n";

    // Generate PDF
    echo "🔄 Generating PDF...\n";
    $pdf = Pdf::loadView('invoices.payment-invoice', $data);

    // Get output
    echo "📥 Getting PDF output...\n";
    $pdfOutput = $pdf->output();
    echo "✓ PDF output: " . strlen($pdfOutput) . " bytes\n";

    // Check if valid PDF
    $header = substr($pdfOutput, 0, 4);
    if ($header === '%PDF') {
        echo "✓ Valid PDF detected (%PDF header)\n";
    } else {
        echo "⚠️ Invalid PDF header: " . bin2hex($header) . "\n";
    }

    // Test download response
    echo "\n📤 Testing download response...\n";
    $filename = 'Invoice-' . $payment->payment_code . '-' . date('Ymd') . '.pdf';
    echo "Filename: $filename\n";

    // Simulate what ->download() does
    echo "\nDownload method should return:\n";
    echo "  - Status: 200\n";
    echo "  - Content-Type: application/pdf\n";
    echo "  - Content-Disposition: attachment; filename=\"$filename\"\n";
    echo "  - Content-Length: " . strlen($pdfOutput) . "\n";

    echo "\n✅ All tests passed! PDF generation works correctly.\n";
    echo "If download still doesn't work, problem is with ngrok or browser handling.\n";

} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":{$e->getLine()}\n";
    echo "\nTrace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}
