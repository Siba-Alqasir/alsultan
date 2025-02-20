<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Setting extends JsonModel implements HasMedia
{
    use HasFactory, HasTranslations,InteractsWithMedia;

    public $fillable = ['key', 'value'];

    public $translatable = ['value'];
}
