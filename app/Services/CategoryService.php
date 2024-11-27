<?php
namespace App\Services;

use App\DTOs\CategoryDTO;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    protected CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories(): Collection
    {
        return $this->categoryRepository->getAll();
    }
    public function getAllWithProducts(): Collection
    {
        return $this->categoryRepository->getAllWithProducts();
    }
    public function createCategory(CategoryDTO $categoryDTO): Category
    {
        return $this->categoryRepository->create([
            'name_en' => $categoryDTO->name_en,
            'name_ar' => $categoryDTO->name_ar,
        ]);
    }
}
