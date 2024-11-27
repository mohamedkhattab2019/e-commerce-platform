<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inventory;

class InventorySeeder extends Seeder
{
    public function run()
    {
        // Create inventory for each product
        Inventory::create([
            'product_id' => 1, // Smartphone
            'quantity' => 50,
        ]);

        Inventory::create([
            'product_id' => 2, // Laptop
            'quantity' => 30,
        ]);

        Inventory::create([
            'product_id' => 3, // Sofa
            'quantity' => 20,
        ]);

        Inventory::create([
            'product_id' => 4, // Dining Table
            'quantity' => 15,
        ]);
    }
}
