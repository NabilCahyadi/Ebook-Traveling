<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Download invoice as PDF
     */
    public function download(Payment $payment)
    {
        // Check if user owns this payment
        if (Auth::user()->id !== $payment->user_id) {
            throw new AuthorizationException('Unauthorized');
        }

        // Check if payment is completed
        if ($payment->status !== 'success') {
            return back()->with('error', 'Invoice is not available for this payment. Only completed payments can be downloaded.');
        }

        try {
            $data = $this->prepareInvoiceData($payment);
            $pdf = Pdf::loadView('invoices.payment-invoice', $data);
            $filename = 'Invoice-' . $payment->payment_code . '-' . date('Ymd') . '.pdf';

            // Get PDF content and send as response
            $pdfContent = $pdf->output();

            return response($pdfContent, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $filename . '"',
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to generate invoice. Please try again later.');
        }
    }

    /**
     * Preview invoice in browser
     */
    public function preview(Payment $payment)
    {
        // Check if user owns this payment
        if (Auth::user()->id !== $payment->user_id) {
            throw new AuthorizationException('Unauthorized');
        }

        $data = $this->prepareInvoiceData($payment);

        $pdf = Pdf::loadView('invoices.payment-invoice', $data);

        return $pdf->stream();
    }

    /**
     * Prepare data for invoice template
     */
    private function prepareInvoiceData(Payment $payment)
    {
        $payment->load('user', 'plan', 'subscription');

        return [
            'payment' => $payment,
            'user' => $payment->user,
            'plan' => $payment->plan,
            'subscription' => $payment->subscription,
            'invoiceDate' => $payment->created_at,
            'invoiceNumber' => $payment->payment_code,
            'dueDate' => $payment->expired_at ?? $payment->created_at->addDays(7),
        ];
    }
}
