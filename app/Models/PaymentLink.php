<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentLink extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'invoice_number',
        'user_id',
        'plan_id',
        'payment_url',
        'mayar_payment_id',
        'amount',
        'status',
        'expires_at',
        'paid_at',
        'payment_method',
        'mayar_response',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'expires_at' => 'datetime',
        'paid_at' => 'datetime',
        'payment_method' => 'array',
        'mayar_response' => 'array',
    ];

    /**
     * Get the user that owns the payment link.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the subscription plan.
     */
    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'plan_id');
    }

    /**
     * Check if payment link is expired.
     */
    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Check if payment is paid.
     */
    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    /**
     * Check if payment link is still valid.
     */
    public function isValid(): bool
    {
        return $this->status === 'pending' && !$this->isExpired();
    }
}
