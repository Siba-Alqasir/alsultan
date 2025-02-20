<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Statistic extends JsonModel
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'title',
        'value',
        'metrics'
    ];
    public $translatable = [
        'title',
        'metrics'
    ];
}
