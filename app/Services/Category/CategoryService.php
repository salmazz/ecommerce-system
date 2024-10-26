<?php

namespace App\Services\Category;


use App\Repositories\Category\CategoryRepositoryInterface;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Get all categories.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllCategories($perPage = 10)
    {
        return $this->categoryRepository->getAllCategories($perPage);
    }
}
