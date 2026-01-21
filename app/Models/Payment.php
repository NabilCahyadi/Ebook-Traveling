<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory, HasUuids;

    // ✅ Sesuaikan dengan struktur tabel
    protected $fillable = [
        'user_id',
        'subscription_plan_id',
        'order_id',
        'subscription_id',
        'payment_code',
        'amount',
        'payment_method',
        'status',
        'payment_gateway',
        'gateway_transaction_id',
        'gateway_response',
        'receipt_image',
        'admin_notes',
        'paid_at',
        'expired_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'expired_at' => 'datetime',
        'gateway_response' => 'array',
    ];

    /**
     * Get the order that owns the payment.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the subscription for the payment.
     */
    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'subscription_id');
    }

    // app/Models/Payment.php
    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }
}
