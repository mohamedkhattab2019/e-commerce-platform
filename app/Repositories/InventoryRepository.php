<?php
namespace App\Repositories;

use App\Models\Inventory;

class InventoryRepository
{
    public function updateOrCreate(array $conditions, array $data)
    {
        return Inventory::updateOrCreate($conditions, $data);
    }
    public function getProductInventory(int $productId)
    {
        return Inventory::where('product_id', $productId)->first();
    }
}
