<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Page extends JsonModel implements HasMedia
{
    use HasFactory, HasTranslations, InteractsWithMedia;

    protected $fillable = [
        'key',
        'slug',
        'title',
        'sub_title',
        'date',
        'description',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'is_required',
        'removed_inputs'
    ];
    public $translatable = [
        'slug',
        'title',
        'sub_title',
        'date',
        'description',
        'meta_title',
        'meta_description',
        'meta_keyword'
    ];
    protected $casts = [
        'is_required' => 'array',
        'removed_inputs' => 'array'
    ];
}
