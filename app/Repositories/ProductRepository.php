<?php
namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository
{
   
    public function getAll(): Collection
    {
        return Product::with(['category','inventory'])->get();
    }
    public function getById(int $id): ?Product
    {
        return Product::with(['category','inventory'])->find($id);
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }
    public function update(int $id, array $data): bool
    {
        $product = Product::findOrFail($id);
        return $product->update($data);
    }
    public function delete(int $id): bool
    {
        $product = Product::findOrFail($id);
        return $product->delete();
    }
    public function getByCategoryId(int $categoryId): Collection
    {
        return Product::where('category_id', $categoryId)->with(['category','inventory'])->get();
    }
}
