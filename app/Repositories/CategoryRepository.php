<?php
namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository
{
    /**
     * Retrieve all categories without their products.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Category::all();
    }
    public function getAllWithProducts(): Collection
    {
        return Category::with('products')->get();
    }

    public function create(array $data): Category
    {
        return Category::create($data);
    }
    
}
