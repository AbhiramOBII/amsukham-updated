<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoSetting extends Model
{
    protected $fillable = [
        'page_identifier',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_title',
        'og_description',
        'og_image',
    ];

    public static function getForPage(string $identifier): ?self
    {
        return static::where('page_identifier', $identifier)->first();
    }
}
