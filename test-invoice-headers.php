<?php

// Bootstrap Laravel
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\InvoiceController;

$payment = Payment::where('status', 'success')->first();
if (! $payment) {
    echo "No success payment found\n";
    exit(1);
}

// Login as payment user
Auth::loginUsingId($payment->user_id);

$controller = new InvoiceController();
$response = $controller->download($payment);

// Inspect response in detail
if (is_object($response)) {
    $class = get_class($response);
    echo "✓ Response class: $class\n\n";

    if (method_exists($response, 'headers')) {
        echo "Response Headers:\n";
        echo "================\n";
        $headers = $response->headers->all();
        if (count($headers) > 0) {
            foreach ($headers as $k => $v) {
                $val = implode(';', $v);
                echo "$k: $val\n";
            }
        } else {
            echo "(No headers in response object)\n";
        }
    }

    if (method_exists($response, 'getStatusCode')) {
        echo "\nStatus Code: " . $response->getStatusCode() . "\n";
    }

    // Get content
    $content = $response->getContent();
    $len = strlen($content);
    echo "\nContent Length: $len bytes\n";

    // Check if PDF magic number exists
    $magic = substr($content, 0, 4);
    $isPdf = $magic === '%PDF';
    echo "Is valid PDF: " . ($isPdf ? "✓ Yes (magic: $magic)" : "✗ No (magic: " . bin2hex($magic) . ")") . "\n";

    if ($len > 0 && $isPdf) {
        echo "\n✓ PDF generation successful!\n";
    } else if ($len > 0) {
        echo "\n⚠ Content generated but not a valid PDF.\n";
        echo "First 200 chars:\n";
        echo substr($content, 0, 200) . "\n";
    }
} else {
    echo "❌ Controller returned non-object response\n";
    var_export($response);
}
