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
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        .header {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }

        .header h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 5px;
        }

        .header .invoice-number {
            font-size: 13px;
            color: #666;
            margin-bottom: 15px;
        }

        .header-row {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            color: #666;
        }

        .section {
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #333;
            text-transform: uppercase;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            margin-bottom: 6px;
            line-height: 1.5;
        }

        .info-label {
            color: #666;
            min-width: 140px;
        }

        .info-value {
            color: #333;
            font-weight: 500;
            text-align: right;
            flex: 1;
        }

        .divider {
            border-top: 1px solid #eee;
            margin: 20px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 13px;
        }

        thead {
            background: #f5f5f5;
            border-bottom: 1px solid #ddd;
        }

        th {
            padding: 10px 8px;
            text-align: left;
            font-weight: bold;
            color: #333;
            font-size: 12px;
        }

        td {
            padding: 10px 8px;
            border-bottom: 1px solid #eee;
        }

        .text-right {
            text-align: right;
        }

        .summary-box {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
        }

        .summary-item {
            min-width: 250px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            margin-bottom: 8px;
            padding: 0 8px;
        }

        .summary-row.total {
            border-top: 1px solid #ddd;
            padding-top: 8px;
            font-weight: bold;
            font-size: 15px;
            color: #333;
        }

        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 1px solid #eee;
            text-align: center;
            font-size: 11px;
            color: #999;
        }

        .small-text {
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>INVOICE</h1>
            <div class="invoice-number">{{ $invoiceNumber }}</div>
            <div class="header-row">
                <div>{{ $invoiceDate->format('d F Y') }}</div>
                <div>
                    @if($payment->status === 'success')
                        <strong>PAID</strong>
                    @elseif($payment->status === 'pending')
                        PENDING
                    @else
                        {{ strtoupper($payment->status) }}
                    @endif
                </div>
            </div>
        </div>

        <!-- Customer Info -->
        <div class="section">
            <div class="section-title">Bill To</div>
            <div class="info-row">
                <div class="info-label">Name:</div>
                <div class="info-value">{{ $user->name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Email:</div>
                <div class="info-value">{{ $user->email }}</div>
            </div>
        </div>

        <div class="divider"></div>

        <!-- Items -->
        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="text-right" style="width: 140px;">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>{{ $plan->name ?? 'Subscription Plan' }}</strong>
                        <br>
                        @if($subscription)
                            <span class="small-text">
                                {{ $subscription->start_date->format('d M Y') }} - {{ $subscription->end_date->format('d M Y') }}
                            </span>
                        @endif
                    </td>
                    <td class="text-right">
                        <strong>Rp {{ number_format($payment->amount, 0, ',', '.') }}</strong>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Summary -->
        <div class="summary-box">
            <div class="summary-item">
                <div class="summary-row">
                    <span>Subtotal:</span>
                    <span>Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                </div>
                <div class="summary-row">
                    <span>Tax:</span>
                    <span>Rp 0</span>
                </div>
                <div class="summary-row total">
                    <span>Total:</span>
                    <span>Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="divider"></div>

        <!-- Payment Info -->
        <div class="section">
            <div class="section-title">Payment Details</div>
            <div class="info-row">
                <div class="info-label">Method:</div>
                <div class="info-value">{{ ucfirst($payment->payment_method ?? '-') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Gateway:</div>
                <div class="info-value">{{ ucfirst($payment->payment_gateway ?? '-') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Transaction ID:</div>
                <div class="info-value">{{ $payment->gateway_transaction_id ?? $payment->id }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Date Paid:</div>
                <div class="info-value">{{ $payment->paid_at ? $payment->paid_at->format('d F Y') : 'Pending' }}</div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Thank you for being part of MeatMap</p>
            <p style="margin-top: 8px;">MeatMap &copy; {{ date('Y') }}</p>
        </div>
    </div>
</body>
</html>
