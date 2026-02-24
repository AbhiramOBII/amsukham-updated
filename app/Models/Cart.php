<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
        'product_color_id',
        'quantity',
        'price',
        'with_blouse',
    ];

    protected $casts = [
        'with_blouse' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productColor()
    {
        return $this->belongsTo(ProductColor::class);
    }

    public function getTotalAttribute(): float
    {
        $unitPrice = $this->price ?? $this->product->display_price;
        return $unitPrice * $this->quantity;
    }
}
