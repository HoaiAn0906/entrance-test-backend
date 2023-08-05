<?php

namespace Modules\Products\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Products\Entities\ProductCategory;

class ProductCategoryTransformer extends TransformerAbstract
{
    protected array $defaultIncludes = [
        'products',
    ];

    /**
     * Transform the resource into an array.
     *
     * @param \Modules\Products\Entities\ProductCategory  $model
     * @return array
     */
    public function transform(ProductCategory $model)
    {
        return [
            'id' => $model->id,
            'data' => [
                'name' => $model->name,
            ],
            'parent_id' => $model->parent_id,
            'depth' => $model->depth,
            'children' => $model->children->toArray(),
            'ascendants' => $model->ancestors->toArray(),
            'descendants' => $model->descendants->toArray(),
        ];
    }

    public function includeProducts(ProductCategory $model)
    {
        return $this->collection($model->products, new ProductTransformer());
    }
}
