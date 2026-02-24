<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductColorImage extends Model
{
    protected $fillable = [
        'product_color_id',
        'media_id',
        'is_primary',
        'sort_order',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function productColor()
    {
        return $this->belongsTo(ProductColor::class);
    }

    public function media()
    {
        return $this->belongsTo(Media::class);
    }
}
