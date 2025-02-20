<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBySizeAttribute extends JsonModel
{
    use HasFactory;

    protected $fillable = [
        'attribute_type',
        'attribute_id',
        'product_by_size_id'
    ];

    public function product()
    {
        return $this->belongsTo(ProductBySize::class, 'product_by_size_id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'attribute_id');
    }

    public function finish()
    {
        return $this->belongsTo(Finish::class, 'attribute_id');
    }
}
