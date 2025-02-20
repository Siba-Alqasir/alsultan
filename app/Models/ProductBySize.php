<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductBySize extends JsonModel implements HasMedia
{
    use HasFactory, HasTranslations, InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'description'
    ];
    public $translatable = [
        'description'
    ];

    public function colors()
    {
        return $this->hasMany(ProductBySizeAttribute::class, 'product_by_size_id')->where('attribute_type', 'color');
    }

    public function finishes()
    {
        return $this->hasMany(ProductBySizeAttribute::class, 'product_by_size_id')->where('attribute_type', 'finish');
    }
}
