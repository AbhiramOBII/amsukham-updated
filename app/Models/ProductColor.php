<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    protected $fillable = [
        'product_id',
        'color_id',
        'sku',
        'stock',
        'price_adjustment',
    ];

    protected $casts = [
        'price_adjustment' => 'decimal:2',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function images()
    {
        return $this->hasMany(ProductColorImage::class)->orderBy('sort_order');
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductColorImage::class)->where('is_primary', true);
    }
}
