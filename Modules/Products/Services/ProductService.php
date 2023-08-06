<?php
namespace  Modules\Products\Services;

use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Modules\Products\Entities\Product;
use Modules\Products\Repositories\ProductCategoryRepository;
use Modules\Products\Repositories\ProductRepository;

class ProductService extends BaseService
{
    protected $productRepository;
    protected $productCategoryRepository;

    public function __construct(ProductRepository $productRepository, ProductCategoryRepository $productCategoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->productCategoryRepository = $productCategoryRepository;
    }

    public function getProducts(array $params)
    {
        if(!empty(data_get($params, 'product_category_id'))) {
            $productCategories = $this->productCategoryRepository->find(data_get($params, 'product_category_id'))->descendants;
            $arrayProductCategories = $productCategories->pluck('id')->toArray();
            $arrayProductCategories[] = data_get($params, 'product_category_id');
        } else {
            $arrayProductCategories = [];
        }

        if (empty($arrayProductCategories)) {
            return $this->productRepository
                ->orderBy('created_at', 'desc')
                ->paginate($params['limit'] ?? config('repository.pagination.limit'));
        } else {
            return $this->productRepository
                ->whereIn('product_category_id', $arrayProductCategories)
                ->orderBy('created_at', 'desc')
                ->paginate($params['limit'] ?? config('repository.pagination.limit'));
        }
    }

    public function createProduct(array $attrs, $file)
    {
        try {
            DB::beginTransaction();

            $name = $file->getClientOriginalName();
            $imagePath = $file->storeAs('product', $name, 'public');

            $product = $this->productRepository->create([
                'name' => data_get($attrs, 'name'),
                'description' => data_get($attrs, 'description'),
                'amount' => data_get($attrs, 'amount'),
                'image' => $imagePath,
                'product_category_id' => data_get($attrs, 'product_category_id'),
            ]);
            DB::commit();

            return $product;
        } catch (\Throwable $th) {
            DB::rollBack();

            throw $th;
        }
    }

    public function deleteProduct($id)
    {
        try {
            DB::beginTransaction();

            $product = $this->productRepository->delete($id);
            DB::commit();

            return $product;
        } catch (\Throwable $th) {
            DB::rollBack();

            throw $th;
        }
    }

    public function updateProduct(array $attrs, $id)
    {
        try {
            DB::beginTransaction();

            $product = $this->productRepository->update($attrs, $id);
            DB::commit();

            return $product;
        } catch (\Throwable $th) {
            DB::rollBack();

            throw $th;
        }
    }
}
