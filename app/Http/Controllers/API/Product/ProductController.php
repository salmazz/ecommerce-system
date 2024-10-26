<?php

namespace App\Http\Controllers\API\Product;

use App\Common\Helpers\JsonResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Services\Product\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $products = $this->productService->getAllProducts(
            $request->get('per_page', 10),
            $request->get('search'),
            $request->get('min_price'),
            $request->get('max_price')
        );
        return JsonResponseHelper::paginatedJsonResponse('Products retrieved successfully', ['items' => new ProductCollection($products)], 200);
    }

    public function store(StoreRequest $request)
    {
        $product = $this->productService->createProduct($request->validated());

        $this->productService->clearProductCache();

        return JsonResponseHelper::jsonResponse('Product created successfully', [new ProductResource($product)], 201);
    }

    public function update($id, UpdateRequest $request)
    {
        $product = $this->productService->updateProduct($id, $request->validated());

        $this->productService->clearProductCache();

        return JsonResponseHelper::jsonResponse('Product created successfully', [new ProductResource($product)], 201);
    }

    public function destroy($id)
    {
        $this->productService->deleteProduct($id);

        $this->productService->clearProductCache();

        return JsonResponseHelper::jsonResponse('Product Deleted successfully', [], 201);
    }
}
