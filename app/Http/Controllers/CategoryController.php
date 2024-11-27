<?php
namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Http\Resources\CategoryResource;
use App\DTOs\CategoryDTO;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        return CategoryResource::collection($this->categoryService->getAllCategories());
    }

    public function showWithProducts()
    {
        $category = $this->categoryService->getAllWithProducts();

        return  CategoryResource::collection($category);
    }

    public function store(Request $request)
    {
        try {
            $categoryDTO = CategoryDTO::fromArray($request->all());
            $category = $this->categoryService->createCategory($categoryDTO);
            
            return response()->json(['data' => new CategoryResource($category)], 201);

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}
