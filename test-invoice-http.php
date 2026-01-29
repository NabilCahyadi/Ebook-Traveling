<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\InvoiceController;

$payment = Payment::where('status', 'success')->first();
if (! $payment) {
    echo "No success payment found\n";
    exit(1);
}

// Create a request object to simulate HTTP request
$request = Request::create(
    "/user/invoice/{$payment->id}/download",
    'GET',
    [],
    [],
    [],
    [
        'HTTP_HOST' => 'localhost:8000',
        'HTTP_USER_AGENT' => 'Test Script',
    ]
);

// Set the request in the app container
app('request', $request);

// Login user
Auth::loginUsingId($payment->user_id);

// Call controller with route model binding
$controller = new InvoiceController();
$response = $controller->download($payment);

echo "Response Status: " . $response->getStatusCode() . "\n";
echo "Response Type: " . get_class($response) . "\n";
echo "\nResponse Headers:\n";
echo "=================\n";

foreach ($response->headers as $key => $value) {
    echo "$key: " . $value->getValueAsString() . "\n";
}

$content = $response->getContent();
echo "\nContent Length: " . strlen($content) . " bytes\n";
echo "Is PDF: " . (substr($content, 0, 4) === '%PDF' ? 'Yes' : 'No') . "\n";
