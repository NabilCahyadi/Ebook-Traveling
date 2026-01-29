<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $invoiceNumber }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', monospace;
            background: #f5f5f5;
            padding: 20px;
        }

        .receipt {
            max-width: 380px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 1px dashed #333;
            padding-bottom: 15px;
        }

        .header h1 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 3px;
            letter-spacing: 1px;
        }

        .header p {
            font-size: 11px;
            color: #666;
            margin: 2px 0;
        }

        .header .invoice-number {
            font-size: 12px;
            margin-top: 8px;
            color: #333;
            font-weight: bold;
        }

        .header .date {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
        }

        /* Status */
        .status {
            text-align: center;
            margin-bottom: 15px;
            font-size: 12px;
            font-weight: bold;
        }

        .status.paid {
            color: #27ae60;
        }

        .status.pending {
            color: #f39c12;
        }

        /* Customer Info */
        .section {
            margin-bottom: 15px;
            border-bottom: 1px dashed #ddd;
            padding-bottom: 12px;
        }

        .section-title {
            font-size: 10px;
            font-weight: bold;
            color: #333;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 6px;
        }

        .info-line {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin: 3px 0;
            color: #333;
        }

        .label {
            font-weight: bold;
        }

        .value {
            text-align: right;
        }

        /* Items */
        .items {
            margin-bottom: 15px;
        }

        .item {
            border-bottom: 1px dashed #ddd;
            padding: 10px 0;
        }

        .item-name {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .item-period {
            font-size: 10px;
            color: #666;
            margin-bottom: 5px;
        }

        .item-price {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            font-weight: bold;
        }

        /* Total */
        .total-section {
            margin-bottom: 15px;
            padding: 8px 0;
        }

        .total-line {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin: 3px 0;
        }

        .total-line.amount {
            font-size: 11px;
            color: #666;
        }

        .total-amount {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            font-weight: bold;
            border-top: 2px solid #333;
            border-bottom: 2px solid #333;
            padding: 8px 0;
            margin: 8px 0;
        }

        /* Payment Details */
        .payment-details {
            margin-bottom: 15px;
            border-bottom: 1px dashed #ddd;
            padding-bottom: 12px;
        }

        .payment-detail {
            font-size: 11px;
            margin: 4px 0;
            color: #333;
        }

        .payment-label {
            font-weight: bold;
        }

        .payment-value {
            margin-left: 10px;
            word-break: break-all;
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 15px;
            padding-top: 12px;
            border-top: 1px dashed #ddd;
            font-size: 11px;
            color: #666;
        }

        .footer p {
            margin: 3px 0;
        }

        .divider {
            text-align: center;
            font-size: 14px;
            margin: 10px 0;
            color: #ddd;
        }

        /* Print */
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .receipt {
                max-width: 100%;
                border: none;
                box-shadow: none;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <!-- Header -->
        <div class="header">
            <h1>MEATMAP</h1>
            <p>Premium eBook Subscription</p>
            <div class="invoice-number">INVOICE #{{ $invoiceNumber }}</div>
            <div class="date">{{ $invoiceDate->format('d M Y H:i') }}</div>
        </div>

        <!-- Customer -->
        <div class="section">
            <div class="section-title">Customer</div>
            <div class="info-line">
                <span class="label">Name</span>
                <span class="value">{{ $user->name }}</span>
            </div>
            <div class="info-line">
                <span class="label">Email</span>
                <span class="value" style="font-size: 10px;">{{ $user->email }}</span>
            </div>
        </div>

        <!-- Items -->
        <div class="items">
            <div class="section-title" style="margin-bottom: 8px;">Item</div>
            <div class="item">
                <div class="item-name">{{ $plan->name ?? 'Subscription Plan' }}</div>
                @if($subscription)
                    <div class="item-period">
                        {{ $subscription->start_date->format('d M Y') }} - {{ $subscription->end_date->format('d M Y') }}
                    </div>
                @endif
                <div class="item-price">
                    <span>1x</span>
                    <span>Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Total -->
        <div class="total-section">
            <div class="total-line amount">
                <span>Subtotal</span>
                <span>Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
            </div>
            <div class="total-line amount">
                <span>Tax (0%)</span>
                <span>Rp 0</span>
            </div>
            <div class="total-amount">
                <span>TOTAL</span>
                <span>Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Payment Details -->
        <div class="payment-details">
            <div class="section-title" style="margin-bottom: 8px;">Payment</div>
            <div class="payment-detail">
                <span class="payment-label">Method:</span>
                <span class="payment-value">{{ ucfirst($payment->payment_method ?? 'E-Wallet') }}</span>
            </div>
            <div class="payment-detail">
                <span class="payment-label">Gateway:</span>
                <span class="payment-value">{{ ucfirst($payment->payment_gateway ?? 'Mayar.id') }}</span>
            </div>
            <div class="payment-detail">
                <span class="payment-label">Transaction:</span>
                <span class="payment-value">{{ substr($payment->gateway_transaction_id ?? $payment->id, 0, 20) }}...</span>
            </div>
            @if($payment->paid_at)
                <div class="payment-detail">
                    <span class="payment-label">Paid:</span>
                    <span class="payment-value">{{ $payment->paid_at->format('d M Y H:i') }}</span>
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="divider">- - - - - - - - - - - - - - - -</div>
            <p>Thank you for your subscription!</p>
            <p style="margin-top: 5px;">https://dev-new.mappy.id/</p>
            <p style="margin-top: 5px; font-size: 10px;">MeatMap © {{ date('Y') }}</p>
        </div>
    </div>
</body>
</html>
