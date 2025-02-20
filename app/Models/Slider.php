<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Slider extends JsonModel implements HasMedia
{
    use HasFactory, HasTranslations, InteractsWithMedia;

    protected $fillable = [
        'title',
        'sub_title',
        'description',
        'btn_title',
        'btn_title_second',
        'btn_link',
        'is_video',
        'is_active'
    ];
    public $translatable = [
        'title',
        'sub_title',
        'description',
        'btn_title',
        'btn_title_second',
        'btn_link',
    ];

    public function scopeActive($query){
        return $query->where('is_active', 1);
    }
}
