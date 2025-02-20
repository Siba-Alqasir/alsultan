<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Type extends JsonModel
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'title',
        'description',
        'category_id'
    ];
    public $translatable = [
        'title',
        'description'
    ];
}
