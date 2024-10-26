<?php
namespace App\Repositories\Product;

use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAllProducts(int $perPage = 10, string $search = null, $minPrice = null, $maxPrice = null)
    {
        $query = Product::query();

        $query = Product::query();

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }

        return $query->paginate($perPage);
    }
    public function getProductById(int $id)
    {
        return Product::findOrFail($id);
    }

    public function createProduct(array $data)
    {
        return Product::create($data);
    }

    public function updateProduct(int $id, array $data)
    {
        $product = Product::findOrFail($id);
        $product->update($data);
        return $product;
    }

    public function deleteProduct(int $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return true;
    }


    public function decreaseStock($productId, $quantity)
    {
        $product = $this->getProductById($productId);

        if ($product && $product->stock >= $quantity) {
            $product->decrement('stock', $quantity);
        }
    }
}
