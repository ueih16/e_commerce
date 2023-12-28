<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends \App\Models\Product
{
    use HasFactory, HasSlug, SoftDeletes;

    protected $fillable = [
        'title',
        'image',
        'title',
        'description',
        'price',
        'image_mime',
        'image_size',
        'created_by',
        'updated_by',
        'published',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'id';
    }
}
