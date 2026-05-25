<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'sku',
        'category_id',
        'fabric_id',
        'work_id',
        'thumbnail_id',
        'length',
        'blouse_length',
        'with_blouse',
        'short_description',
        'description',
        'price',
        'discount',
        'discounted_price',
        'stock',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
        'discounted_price' => 'decimal:2',
        'with_blouse' => 'boolean',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
            $product->discounted_price = $product->calculateDiscountedPrice();
        });

        static::updating(function ($product) {
            $product->discounted_price = $product->calculateDiscountedPrice();
        });
    }

    public function calculateDiscountedPrice(): float
    {
        if ($this->discount > 0) {
            return round($this->price - ($this->price * $this->discount / 100));
        }
        return $this->price;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function fabric()
    {
        return $this->belongsTo(Fabric::class);
    }

    public function work()
    {
        return $this->belongsTo(Work::class);
    }

    public function thumbnail()
    {
        return $this->belongsTo(Media::class, 'thumbnail_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function faqs()
    {
        return $this->hasMany(ProductFaq::class);
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'product_colors')
            ->withPivot('sku', 'stock', 'price_adjustment')
            ->withTimestamps();
    }

    public function productColors()
    {
        return $this->hasMany(ProductColor::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getDisplayPriceAttribute(): float
    {
        return $this->discounted_price ?? $this->price;
    }
}
