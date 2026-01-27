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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f5f5f5;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 40px;
            background: white;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 2px solid #FF416C;
        }
        
        .logo-section h1 {
            color: #FF416C;
            font-size: 28px;
            margin-bottom: 5px;
        }
        
        .logo-section p {
            color: #666;
            font-size: 13px;
        }
        
        .invoice-details {
            text-align: right;
        }
        
        .invoice-details h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 10px;
        }
        
        .invoice-meta {
            font-size: 13px;
            color: #666;
            line-height: 1.8;
        }
        
        .invoice-meta strong {
            color: #333;
        }
        
        .section {
            margin-bottom: 30px;
        }
        
        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            margin-bottom: 8px;
            line-height: 1.6;
        }
        
        .info-label {
            color: #666;
            min-width: 150px;
        }
        
        .info-value {
            color: #333;
            font-weight: 500;
            text-align: right;
            flex: 1;
        }
        
        .divider {
            border-top: 1px solid #eee;
            margin: 25px 0;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            font-size: 14px;
        }
        
        thead {
            background: #f9f9f9;
            border-bottom: 2px solid #FF416C;
        }
        
        th {
            padding: 12px;
            text-align: left;
            font-weight: bold;
            color: #333;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        
        .text-right {
            text-align: right;
        }
        
        .summary {
            margin-top: 30px;
            display: flex;
            justify-content: flex-end;
        }
        
        .summary-box {
            min-width: 300px;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 14px;
        }
        
        .summary-row.total {
            border-top: 2px solid #FF416C;
            padding-top: 12px;
            font-weight: bold;
            color: #FF416C;
            font-size: 18px;
        }
        
        .summary-label {
            color: #666;
        }
        
        .summary-value {
            color: #333;
            font-weight: 500;
        }
        
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            font-size: 12px;
            color: #999;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-paid {
            background: #d4edda;
            color: #155724;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        
        .status-failed {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo-section">
                <h1>Mappy.ID</h1>
                <p>Premium E-Book Platform</p>
            </div>
            <div class="invoice-details">
                <h2>INVOICE</h2>
                <div class="invoice-meta">
                    <div><strong>No. Invoice:</strong> {{ $invoiceNumber }}</div>
                    <div><strong>Tanggal:</strong> {{ $invoiceDate->format('d F Y') }}</div>
                    <div><strong>Status:</strong> 
                        @if($payment->status === 'success')
                            <span class="status-badge status-paid">PAID</span>
                        @elseif($payment->status === 'pending')
                            <span class="status-badge status-pending">PENDING</span>
                        @else
                            <span class="status-badge status-failed">{{ strtoupper($payment->status) }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Bill To Section -->
        <div class="section">
            <div class="section-title">Bill To</div>
            <div class="info-row">
                <div class="info-label">Nama:</div>
                <div class="info-value">{{ $user->name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Email:</div>
                <div class="info-value">{{ $user->email }}</div>
            </div>
            @if($user->phone)
            <div class="info-row">
                <div class="info-label">No. Telepon:</div>
                <div class="info-value">{{ $user->phone }}</div>
            </div>
            @endif
        </div>

        <div class="divider"></div>

        <!-- Items Table -->
        <table>
            <thead>
                <tr>
                    <th>Deskripsi</th>
                    <th class="text-right" style="width: 150px;">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>{{ $plan->name ?? 'Subscription Plan' }}</strong><br>
                        <small style="color: #999;">
                            @if($subscription)
                                {{ $subscription->start_date->format('d M Y') }} - {{ $subscription->end_date->format('d M Y') }}
                                <br>
                                {{ $subscription->end_date->diffInDays($subscription->start_date) }} hari akses premium
                            @endif
                        </small>
                    </td>
                    <td class="text-right">
                        <strong>Rp {{ number_format($payment->amount, 0, ',', '.') }}</strong>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Summary -->
        <div class="summary">
            <div class="summary-box">
                <div class="summary-row">
                    <span class="summary-label">Subtotal:</span>
                    <span class="summary-value">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Pajak:</span>
                    <span class="summary-value">Rp 0</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Diskon:</span>
                    <span class="summary-value">Rp 0</span>
                </div>
                <div class="summary-row total">
                    <span>Total:</span>
                    <span>Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Payment Details -->
        <div class="divider"></div>
        <div class="section">
            <div class="section-title">Detail Pembayaran</div>
            <div class="info-row">
                <div class="info-label">Metode Pembayaran:</div>
                <div class="info-value">{{ ucfirst($payment->payment_method ?? 'Mayar.ID') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Gateway:</div>
                <div class="info-value">{{ ucfirst($payment->payment_gateway ?? 'Mayar.ID') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Kode Transaksi:</div>
                <div class="info-value">{{ $payment->gateway_transaction_id ?? $payment->id }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Tanggal Pembayaran:</div>
                <div class="info-value">{{ $payment->paid_at ? $payment->paid_at->format('d F Y H:i') : 'Pending' }}</div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Terima kasih telah menjadi bagian dari Mappy.ID!</p>
            <p style="margin-top: 10px;">Invoice ini adalah dokumen legal untuk transaksi Anda. Simpan invoice ini untuk keperluan Anda.</p>
            <p style="margin-top: 15px; border-top: 1px solid #eee; padding-top: 15px;">
                Mappy.ID &copy; {{ date('Y') }} - Premium E-Book Platform
            </p>
        </div>
    </div>
</body>
</html>
