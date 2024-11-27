<?php
namespace App\Services;

use App\DTOs\ProductDTO;
use App\Models\Product;
use App\Repositories\InventoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    protected ProductRepository $productRepository;
    protected InventoryRepository $inventoryRepository;

    public function __construct(ProductRepository $productRepository,  InventoryRepository $inventoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->inventoryRepository = $inventoryRepository;
    }

    public function getAllProducts(): Collection
    {
        return $this->productRepository->getAll();
    }

    public function getProductById(int $id): ?Product
    {
        return $this->productRepository->getById($id);
    }

    public function getProductsByCategoryId(int $categoryId): Collection
    {
        return $this->productRepository->getByCategoryId($categoryId);
    }

    public function createProduct(ProductDTO $productDTO): Product
    {
        $data = [
            'name_en' => $productDTO->name_en,
            'name_ar' => $productDTO->name_ar,
            'description_en' => $productDTO->description_en,
            'description_ar' => $productDTO->description_ar,
            'price' => $productDTO->price,
            'category_id' => $productDTO->category_id,
            'image' => $productDTO->image,
        ];

        $product = $this->productRepository->create($data);
        $this->inventoryRepository->updateOrCreate(
                        ['product_id' => $product->id],
                        ['quantity' => $productDTO->inventory_quantity ?? 1]
        );
        return $product;
    }
    public function updateProduct(int $id, ProductDTO $productDTO): bool
    {
        $data = [
            'name_en' => $productDTO->name_en,
            'name_ar' => $productDTO->name_ar,
            'description_en' => $productDTO->description_en,
            'description_ar' => $productDTO->description_ar,
            'price' => $productDTO->price,
            'category_id' => $productDTO->category_id,
            'image' => $productDTO->image,
        ];

        return $this->productRepository->update($id, $data);
    }

    public function deleteProduct(int $id): bool
    {
        return $this->productRepository->delete($id);
    }
}
