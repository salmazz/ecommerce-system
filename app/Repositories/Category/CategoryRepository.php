<?php
namespace App\Repositories\Category;

use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getAllCategories($perPage = 10)
    {
        return Category::query()->paginate($perPage);
    }
}
