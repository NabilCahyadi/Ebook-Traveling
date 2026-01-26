<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt-<?php echo e($subscription->subscription_code); ?>-<?php echo e($subscription->created_at->format('Ymd')); ?></title>
    <style>
        @page {
            size: A4;
            margin: 1cm;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            padding: 40px;
            background: #f5f5f5;
        }
        
        .receipt {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        
        .header {
            text-align: center;
            border-bottom: 3px solid #FF4C61;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: #FF4C61;
            font-size: 32px;
            margin-bottom: 5px;
        }
        
        .header p {
            color: #666;
            font-size: 14px;
        }
        
        .receipt-title {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .receipt-title h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 10px;
        }
        
        .receipt-code {
            background: #f8f9fa;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        
        .receipt-code strong {
            color: #FF4C61;
            font-size: 18px;
        }
        
        .info-section {
            margin-bottom: 30px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-label {
            color: #666;
            font-weight: 600;
        }
        
        .info-value {
            color: #333;
            text-align: right;
        }
        
        .amount-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin: 30px 0;
        }
        
        .amount-row {
            display: flex;
            justify-content: space-between;
            font-size: 24px;
            font-weight: bold;
        }
        
        .amount-label {
            color: #666;
        }
        
        .amount-value {
            color: #28a745;
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            background: #28a745;
            color: white;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
        }
        
        .footer {
            margin-top: 50px;
            text-align: center;
            color: #666;
            font-size: 12px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        
        .print-button {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .print-button button {
            background: #FF4C61;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        
        .print-button button:hover {
            background: #5f51d4;
        }
        
        .print-instruction {
            background: #fff3cd;
            border: 2px solid #ffc107;
            padding: 15px;
            margin: 20px auto;
            max-width: 800px;
            border-radius: 5px;
            text-align: center;
        }
        
        .print-instruction strong {
            color: #856404;
            font-size: 14px;
        }
        
        @media print {
            @page {
                size: A4;
                margin: 0;
            }
            
            body {
                padding: 0;
                background: white;
                margin: 0;
            }
            
            .receipt {
                box-shadow: none;
                padding: 40px;
                max-width: 100%;
                page-break-inside: avoid;
                margin: 0;
            }
            
            .print-button, .print-instruction {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <!-- <div class="print-instruction">
        <strong>💡 Tip: Untuk hasil print terbaik, pastikan "Headers and footers" di-OFF di print settings</strong>
    </div> -->
    
    <div class="print-button">
        <button onclick="printReceipt()">🖨️ <?php echo e(__('admin.receipt.print_button')); ?></button>
    </div>
    
    <div class="receipt">
        <div class="header">
            <h1><?php echo e(config('app.name')); ?></h1>
            <p><?php echo e(__('admin.receipt.travel_ebook_platform')); ?></p>
        </div>
        
        <div class="receipt-title">
            <h2><?php echo e(__('admin.receipt.title')); ?></h2>
            <p style="color: #666;"><?php echo e(now()->format('d F Y')); ?></p>
        </div>
        
        <div class="receipt-code">
            <p style="color: #666; margin-bottom: 5px;"><?php echo e(__('admin.receipt.receipt_code')); ?></p>
            <strong><?php echo e($subscription->subscription_code); ?></strong>
        </div>
        
        <div class="info-section">
            <h3 style="color: #333; margin-bottom: 15px; font-size: 18px;"><?php echo e(__('admin.receipt.customer_info')); ?></h3>
            <div class="info-row">
                <span class="info-label"><?php echo e(__('admin.receipt.name')); ?>:</span>
                <span class="info-value"><?php echo e($subscription->user->name); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label"><?php echo e(__('admin.receipt.email')); ?>:</span>
                <span class="info-value"><?php echo e($subscription->user->email); ?></span>
            </div>
            <?php if($subscription->user->phone): ?>
            <div class="info-row">
                <span class="info-label"><?php echo e(__('admin.receipt.phone')); ?>:</span>
                <span class="info-value"><?php echo e($subscription->user->phone); ?></span>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="info-section">
            <h3 style="color: #333; margin-bottom: 15px; font-size: 18px;"><?php echo e(__('admin.receipt.subscription_details')); ?></h3>
            <div class="info-row">
                <span class="info-label"><?php echo e(__('admin.receipt.plan')); ?>:</span>
                <span class="info-value"><?php echo e($subscription->plan->name); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label"><?php echo e(__('admin.receipt.duration')); ?>:</span>
                <span class="info-value">
                    <?php
                        $days = $subscription->start_date->diffInDays($subscription->end_date);
                        if ($days == 30 || $days == 31) {
                            echo '1 ' . __('admin.receipt.month');
                        } elseif ($days == 90 || $days == 91 || $days == 92) {
                            echo '3 ' . __('admin.receipt.months');
                        } elseif ($days == 365 || $days == 366) {
                            echo '1 ' . __('admin.receipt.year');
                        } else {
                            echo $days . ' ' . __('admin.receipt.days');
                        }
                    ?>
                </span>
            </div>
            <div class="info-row">
                <span class="info-label"><?php echo e(__('admin.receipt.start_date')); ?>:</span>
                <span class="info-value"><?php echo e($subscription->start_date->format('d F Y')); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label"><?php echo e(__('admin.receipt.end_date')); ?>:</span>
                <span class="info-value"><?php echo e($subscription->end_date->format('d F Y')); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label"><?php echo e(__('admin.receipt.payment_type')); ?>:</span>
                <span class="info-value">
                    <?php if($subscription->payment_id): ?>
                        <?php echo e(__('admin.receipt.payment_gateway')); ?>

                    <?php else: ?>
                        <?php echo e(__('admin.receipt.manual_payment')); ?>

                    <?php endif; ?>
                </span>
            </div>
            <div class="info-row">
                <span class="info-label"><?php echo e(__('admin.receipt.payment_date')); ?>:</span>
                <span class="info-value"><?php echo e($subscription->created_at->format('d F Y H:i')); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label"><?php echo e(__('admin.receipt.status')); ?>:</span>
                <span class="info-value">
                    <span class="status-badge"><?php echo e(__('admin.receipt.paid')); ?></span>
                </span>
            </div>
        </div>
        
        <div class="amount-section">
            <div class="amount-row">
                <span class="amount-label"><?php echo e(__('admin.receipt.total_amount')); ?>:</span>
                <span class="amount-value">Rp <?php echo e(number_format($subscription->total_amount, 0, ',', '.')); ?></span>
            </div>
        </div>
        
        <div class="footer">
            <p><?php echo e(__('admin.receipt.thank_you')); ?></p>
            <p><?php echo e(__('admin.receipt.computer_generated')); ?></p>
            <p style="margin-top: 10px;">© <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?>. <?php echo e(__('admin.receipt.all_rights_reserved')); ?></p>
        </div>
    </div>
    
    <script>
        // Generate filename
        const filename = 'Receipt-<?php echo e($subscription->subscription_code); ?>-<?php echo e($subscription->created_at->format("Ymd")); ?>.pdf';
        
        // Set document title for PDF filename
        document.title = filename;
        
        // For browsers that support download attribute
        window.onbeforeprint = function() {
            document.title = filename;
        };
        
        // Alternative: Direct PDF download with better filename
        function printReceipt() {
            // Set title before print
            const originalTitle = document.title;
            document.title = filename;
            
            // Print
            window.print();
            
            // Restore original title
            setTimeout(() => {
                document.title = originalTitle;
            }, 100);
        }
    </script>
</body>
</html>
<?php /**PATH C:\laragon\www\ebook_traveling\resources\views/admin/subscription-history/print.blade.php ENDPATH**/ ?>