<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_color_id',
        'product_name',
        'product_sku',
        'price',
        'discount',
        'discounted_price',
        'quantity',
        'with_blouse',
        'total',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
        'discounted_price' => 'decimal:2',
        'total' => 'decimal:2',
        'with_blouse' => 'boolean',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productColor()
    {
        return $this->belongsTo(ProductColor::class);
    }
}
