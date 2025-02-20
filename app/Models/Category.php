<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends JsonModel implements HasMedia
{
    use HasFactory, HasTranslations, InteractsWithMedia, HasSlug, SoftDeletes;

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    protected $fillable = [
        'title',
        'slug',
        'description',
        'meta_title',
        'meta_description',
        'meta_keyword'
    ];
    public $translatable = [
        'title',
        'slug',
        'description',
        'meta_title',
        'meta_description',
        'meta_keyword'
    ];
}
