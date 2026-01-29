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

// Inspect response
if (is_object($response)) {
    $class = get_class($response);
    echo "Response class: $class\n";
    if (method_exists($response, 'headers')) {
        $headers = $response->headers->all();
        echo "Headers:\n";
        foreach ($headers as $k => $v) {
            echo "  $k: " . implode(';', $v) . "\n";
        }
    }

    // Get content and save to file if present
    $content = $response->getContent();
    $len = strlen($content);
    echo "Content length: $len bytes\n";
    if ($len > 0) {
        $filename = __DIR__ . '/tmp_test_invoice.pdf';
        file_put_contents($filename, $content);
        echo "Saved to $filename\n";
    }
} else {
    echo "Controller returned non-object response: ";
    var_export($response);
    echo "\n";
}

