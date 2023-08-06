<?php

namespace Modules\Products\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Products\Services\ProductCategoryService;
use Modules\Products\Transformers\ProductCategoryTransformer;

class ProductCategoriesController extends Controller
{
    protected $productCategoryService;

    public function __construct(ProductCategoryService $productCategoryService)
    {
        $this->productCategoryService = $productCategoryService;
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $data = $this->productCategoryService->getProductCategories($request->all());

        return responder()->success($data)->respond();
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $this->productCategoryService->createProductCategory($request->all());

        return responder()->success($data)->respond();
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('products::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('products::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $data = $this->productCategoryService->updateProductCategory($request->all(), $id);

        return responder()->success($data)->respond();
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return int
     */
    public function destroy($id)
    {
        return $this->productCategoryService->deleteProductCategory($id);
    }

    public function getProductCategoriesNoTree(Request $request)
    {
        $data = $this->productCategoryService->getProductCategoriesNoTree($request->all());

        return responder()->success($data)->respond();
    }
}
