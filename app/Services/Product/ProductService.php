<?php
namespace App\Services\Product;
use App\Repositories\Product\ProductRepository;
use Illuminate\Support\Facades\Cache;

class ProductService{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Get all categories.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllProducts($perPage = 10, $search = null, $minPrice = null, $maxPrice = null)
    {
        $cacheKey = $this->getCacheKey($perPage, $search, $minPrice, $maxPrice);

        return Cache::remember($cacheKey, 60, function () use ($perPage, $search, $minPrice, $maxPrice) {
            return $this->productRepository->getAllProducts($perPage, $search, $minPrice, $maxPrice);
        });
    }

    public function createProduct(array $data)
    {
        return  $this->productRepository->createProduct($data);
    }

    public function updateProduct(int $id, array $data)
    {
        return $this->productRepository->updateProduct($id, $data);
    }

    public function deleteProduct(int $id)
    {
        return $this->productRepository->deleteProduct($id);
    }

    private function getCacheKey($perPage, $search, $minPrice, $maxPrice)
    {
        return 'products_cache_' . md5("perPage={$perPage}_search={$search}_minPrice={$minPrice}_maxPrice={$maxPrice}");
    }
    public function clearProductCache()
    {
        Cache::flush();
    }
}
