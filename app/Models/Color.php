<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Color extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'hex_code',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($color) {
            if (empty($color->slug)) {
                $color->slug = Str::slug($color->name);
            }
        });

        static::updating(function ($color) {
            if ($color->isDirty('name') && !$color->isDirty('slug')) {
                $color->slug = Str::slug($color->name);
            }
        });
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_colors')
            ->withPivot('sku', 'stock', 'price_adjustment')
            ->withTimestamps();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
