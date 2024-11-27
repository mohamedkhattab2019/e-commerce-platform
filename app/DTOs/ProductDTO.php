<?php
namespace App\DTOs;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProductDTO
{
    public string $name_en;
    public string $name_ar;
    public string $description_en;
    public string $description_ar;
    public float $price;
    public ?int $category_id;
    public ?string $image;
    public ?int $inventory_quantity;


    public function __construct(
        string $name_en,
        string $name_ar,
        string $description_en,
        string $description_ar,
        float $price,
        int $category_id ,
        string $image,
        ?int $inventory_quantity = null
    ) {
        $this->name_en = $name_en;
        $this->name_ar = $name_ar;
        $this->description_en = $description_en;
        $this->description_ar = $description_ar;
        $this->price = $price;
        $this->category_id = $category_id;
        $this->image = $image;
        $this->inventory_quantity = $inventory_quantity;
    }

    public static function fromArray(array $data): self
    {
        $validator = Validator::make($data, [
            'name_ar' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|string|max:2048',
            'inventory_quantity' => 'nullable|integer|min:0',
        ]);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        return new self(
            $data['name_en']??$data['name_ar'],
            $data['name_ar'],
            $data['description_en']??$data['description_ar'],
            $data['description_ar'],
            $data['price'],
            $data['category_id'],
            $data['image'],
            $data['inventory_quantity'] ?? null

        );
    }
}
