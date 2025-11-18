<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'ebook_id',
        'quantity',
        'price',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:2',
    ];

    /**
     * Get the user that owns the cart item.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the ebook.
     */
    public function ebook()
    {
        return $this->belongsTo(Ebook::class);
    }

    /**
     * Get the subtotal for this cart item.
     */
    public function getSubtotalAttribute()
    {
        return $this->quantity * $this->price;
    }
}
