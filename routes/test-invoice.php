<?php

Route::prefix('test')->middleware('auth')->group(function () {
    // Test endpoint untuk debug invoice download
    Route::get('/invoice-download/{payment}', function (\App\Models\Payment $payment) {
        if (auth()->user()->id !== $payment->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            // Prepare data
            $data = [
                'payment' => $payment,
                'user' => $payment->user,
                'plan' => $payment->plan,
                'subscription' => $payment->subscription,
                'invoiceDate' => $payment->created_at,
                'invoiceNumber' => $payment->payment_code,
                'dueDate' => $payment->expired_at ?? $payment->created_at->addDays(7),
            ];

            // Generate PDF
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('invoices.payment-invoice', $data);
            $filename = 'Invoice-' . $payment->payment_code . '-' . date('Ymd') . '.pdf';

            // Log headers that will be sent
            \Log::info('Invoice Download Debug', [
                'filename' => $filename,
                'payment_id' => $payment->id,
                'user_id' => auth()->id(),
            ]);

            return $pdf->download($filename);

        } catch (\Exception $e) {
            \Log::error('Test Invoice Download Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    });

    // Debug endpoint to check if payment/user exists
    Route::get('/payment-check/{payment}', function (\App\Models\Payment $payment) {
        $user = auth()->user();
        return response()->json([
            'payment' => [
                'id' => $payment->id,
                'status' => $payment->status,
                'user_id' => $payment->user_id,
                'amount' => $payment->amount,
                'payment_code' => $payment->payment_code,
            ],
            'auth_user' => [
                'id' => $user->id,
                'name' => $user->name,
            ],
            'authorized' => $user->id === $payment->user_id,
        ]);
    });
});
