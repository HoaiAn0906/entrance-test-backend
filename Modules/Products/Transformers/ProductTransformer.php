<?php

namespace Modules\Products\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Products\Entities\Product;
use Modules\Products\Entities\ProductCategory;

class ProductTransformer extends TransformerAbstract
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Modules\Products\Entities\Product  $model
     * @return array
     */
    public function transform(Product $model)
    {
        return [
            'id' => (int) $model->id,
            'product_category_id' => $model->product_category_id,
            'name' => $model->name,
            'description' => $model->description,
            'image' => $model->image,
            'image_url' => $model->imageUrl,
            'amount' => $model->amount,
            'created_at' => $model->created_at,
            'product_category_name' => $model->productCategory->name ?? '',
        ];
    }
}
