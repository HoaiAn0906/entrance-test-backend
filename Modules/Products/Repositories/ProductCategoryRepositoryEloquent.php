<?php

namespace Modules\Products\Repositories;

use Modules\Products\Entities\ProductCategory;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\BaseRepository;

class ProductCategoryRepositoryEloquent extends BaseRepository implements ProductCategoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProductCategory::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
