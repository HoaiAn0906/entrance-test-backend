<?php

namespace  Modules\Products\Services;

use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Modules\Products\Entities\ProductCategory;
use Modules\Products\Repositories\ProductCategoryRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ProductCategoryService extends BaseService
{
    protected $productCategoryRepository;

    public function __construct(ProductCategoryRepository $productCategoryRepository)
    {
        $this->productCategoryRepository = $productCategoryRepository;
    }

    public function getProductCategories($params)
    {
        return $this->productCategoryRepository
            ->withDepth()
            ->with('ancestors')
            ->with('descendants')
            ->defaultOrder()
            ->paginate($params['limit'] ?? config('repository.pagination.limit'))
            ->toTree();
    }

    public function createProductCategory(array $attrs)
    {
        try {
            DB::beginTransaction();

            $productCategory = $this->productCategoryRepository->create([
                'name' => $attrs['name'],
            ]);

            if(isset($attrs['parent_id']) && $attrs['parent_id'] != 'none') {
                $node = ProductCategory::find($attrs['parent_id']);

                $node->appendNode($productCategory);
            }

            DB::commit();

            return $productCategory;
        } catch (\Throwable $th) {
            DB::rollBack();

            throw $th;
        }
    }

    public function getProductCategoriesNoTree(array $params)
    {
        return QueryBuilder::for(ProductCategory::class)
            ->allowedFilters([
                AllowedFilter::callback('q', function (Builder $query, $q) {
                    return $query->where('name', 'LIKE', "%$q%");
                }),
            ])
            ->defaultSorts('-created_at')
            ->paginate($params['limit'] ?? config('repository.pagination.limit'));
    }

    public function deleteProductCategory($id)
    {
        $data = $this->productCategoryRepository->delete($id);

        return $data;
    }
}
