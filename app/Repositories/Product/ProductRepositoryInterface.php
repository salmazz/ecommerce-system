<?php
namespace App\Repositories\Product;

interface ProductRepositoryInterface
{
    public function getAllProducts(int $perPage = 10, string $search = null, $minPrice = null, $maxPrice = null);
    public function getProductById(int $id);

    public function createProduct(array $data);
    public function updateProduct(int $id, array $data);
    public function deleteProduct(int $id);
}
