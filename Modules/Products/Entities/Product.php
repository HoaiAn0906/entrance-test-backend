<?php

namespace Modules\Products\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_category_id',
        'name',
        'image',
        'amount',
        'description',
    ];

    public function getImageUrlAttribute()
    {
        return $this->image ? \Storage::disk('public')->url($this->image) : null;
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }
}
