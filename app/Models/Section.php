<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;


class Section extends JsonModel implements HasMedia
{
    use HasFactory, SoftDeletes, HasTranslations, InteractsWithMedia;

    protected $fillable = [
        'title',
        'sub_title',
        'description',
        'btn_title',
        'btn_link',
        'highlight',
        'is_required',
        'removed_inputs'
    ];
    public $translatable = [
        'title',
        'sub_title',
        'description',
        'btn_title',
        'btn_link'
    ];

    protected $casts = [
        'is_required' => 'array',
        'removed_inputs' => 'array'
    ];
}
