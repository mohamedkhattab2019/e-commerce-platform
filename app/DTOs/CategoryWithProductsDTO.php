<?php
namespace App\DTOs;

use Illuminate\Support\Collection;

class CategoryWithProductsDTO
{
    public string $name_en;
    public string $name_ar;
    public Collection $products;

    public function __construct(string $name_en, string $name_ar, Collection $products)
    {
        $this->name_en = $name_en;
        $this->name_ar = $name_ar;
        $this->products = $products;
    }

    public static function fromModel($category): self
    {
        return new self(
            $category->name_en,
            $category->name_ar,
            $category->products
        );
    }
}
