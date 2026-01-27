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

        $data = $this->prepareInvoiceData($payment);

        $pdf = Pdf::loadView('invoices.payment-invoice', $data);

        // Generate filename
        $filename = 'Invoice-' . $payment->payment_code . '-' . date('Ymd') . '.pdf';

        return $pdf->download($filename);
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
