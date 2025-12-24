<?php

require 'vendor/autoload.php';

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

// Ambil API Key dan Plan dari database atau hardcode dulu untuk testing
$apiKey = env('MAYAR_API_KEY');
$baseUrl = 'https://api.mayar.id'; // Gunakan URL Production
$plan = (object) [
    'name' => 'Langganan Starter',
    'price' => 20000,
];

// Data user untuk testing
$user = (object) [
    'name' => 'Nabil Cahyadi',
    'email' => 'kahla@gmail.com',
    'phone' => '081234567890',
];

// Payload sesuai dokumentasi Mayar.id
$payload = [
    'amount' => (int) $plan->price,
    'description' => "Subscription: {$plan->name}",
    'payer_name' => $user->name,
    'payer_email' => $user->email,
    'payer_phone' => $user->phone ?? '',
    'callback_url' => 'https://random-string-here.ngrok-free.app/api/payment/mayar-callback', // GANTI dengan URL ngrok Anda
    'return_url' => 'https://random-string-here.ngrok-free.app/subscription/success',
];

Log::info('--- TEST LANGSUNG ---');
Log::info('Mengirim request langsung ke Mayar.id');
Log::info('Endpoint: ' . $baseUrl . '/v1/payment-links');
Log::info('Payload: ' . json_encode($payload));

$response = Http::withHeaders([
    'Authorization' => 'Bearer ' . $apiKey,
    'Accept' => 'application/json',
    'Content-Type' => 'application/json',
])->post($baseUrl . '/v1/payment-links', $payload);

Log::info('Response Status: ' . $response->status());
Log::info('Response Body: ' . $response->body());

if ($response->successful()) {
    $responseData = $response->json();
    Log::info('--- SUKSES! ---');
    Log::info('Payment URL: ' . ($responseData['data']['payment_url'] ?? 'Tidak ada di response'));
    echo "✅ SUKSES! Payment link berhasil dibuat.\n";
    echo "Payment URL: " . ($responseData['data']['payment_url'] ?? 'Tidak ada') . "\n";
} else {
    Log::error('--- GAGAL! ---');
    Log::error('Status: ' . $response->status());
    Log::error('Body: ' . $response->body());
    echo "❌ GAGAL! Gagal membuat payment link.\n";
    echo "Status: " . $response->status() . "\n";
    echo "Body: " . $response->body() . "\n";
}
