<?php

namespace Modules\Auth\Transformers;

use App\Models\User;
use App\Transformers\BaseTransformer;

class UserTransformer extends BaseTransformer
{
    /**
     * Transform the entity.
     *
     * @return array
     */
    public function transform(User $model)
    {
        return [
            'id' => (int) $model->id,
            'name' => $model->name,
            'email' => $model->email,
            'created_at' => $model->created_at,
        ];
    }
}
