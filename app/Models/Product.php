<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends JsonModel implements HasMedia
{
    use HasFactory, HasTranslations, InteractsWithMedia, SoftDeletes, HasSlug;

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    protected $fillable = [
        'title',
        'description',
        'size',
        'weight',
        'serial_number',
        'thickness',
        'area-stone',
        'stones-per-m',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'category_id',
        'slug'
    ];
    
    public $translatable = [
        'title',
        'description',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'slug'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function colors()
    {
        return $this->hasMany(ProductAttribute::class, 'product_id')->where('attribute_type', 'color');
    }

    public function sizes()
    {
        return $this->hasMany(ProductAttribute::class, 'product_id')->where('attribute_type', 'size');
    }

    public function patterns()
    {
        return $this->hasMany(ProductAttribute::class, 'product_id')->where('attribute_type', 'pattern');
    }

    public function finishes()
    {
        return $this->hasMany(ProductAttribute::class, 'product_id')->where('attribute_type', 'finish');
    }

    public function types()
    {
        return $this->hasMany(ProductAttribute::class, 'product_id')->where('attribute_type', 'type');
    }
}
