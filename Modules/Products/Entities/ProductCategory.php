<?php

namespace Modules\Products\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kalnoy\Nestedset\NodeTrait;

class ProductCategory extends Model
{
    use HasFactory, NodeTrait;

    protected $fillable = [
        'name'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function toArray()
    {
        $array = parent::toArray(); // TODO: Change the autogenerated stub

        $customData = [
            'data' => [
                'name' => $this->name,
                'created_at' => $this->created_at->format('d/m/Y H:i:s'),
            ],
            'key' => $this->id,
            'label' => $this->name,
        ];

        return array_merge($array, $customData);
    }
}
