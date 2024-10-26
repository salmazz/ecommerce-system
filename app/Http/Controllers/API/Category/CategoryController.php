<?php

namespace App\Http\Controllers\API\Category;

use App\Common\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryCollection;
use App\Services\Category\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    // Inject the CategoryService
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Get all categories.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $categories = $this->categoryService->getAllCategories($perPage);
    }
}
