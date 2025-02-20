<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class SurfaceTreatment extends JsonModel implements HasMedia
{
    use HasFactory, HasTranslations, InteractsWithMedia;

    protected $fillable = [
        'ordering',
        'title',
        'description',
        'features_desc'
    ];
    public $translatable = [
        'title',
        'description',
        'features_desc'
    ];
    
    public function features()
    {
        return $this->hasMany(TreatmentFeature::class, 'treatment_id');
    }
}
