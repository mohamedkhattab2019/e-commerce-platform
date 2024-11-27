<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Electronics products
        Product::create([
            'name_en' => 'Smartphone',
            'name_ar' => 'هاتف ذكي',
            'description_en' => 'A high-performance smartphone.',
            'description_ar' => 'هاتف ذكي عالي الأداء.',
            'price' => 699.99,
            'category_id' => 1,
            'image' => 'products/smartphone.jpg', // Dummy image path
        ]);

        Product::create([
            'name_en' => 'Laptop',
            'name_ar' => 'لابتوب',
            'description_en' => 'A powerful laptop for professionals.',
            'description_ar' => 'لابتوب قوي للمحترفين.',
            'price' => 1199.99,
            'category_id' => 1,
            'image' => 'products/laptop.jpg', // Dummy image path
        ]);

        // Furniture products
        Product::create([
            'name_en' => 'Sofa',
            'name_ar' => 'كنبة',
            'description_en' => 'A comfortable sofa for your living room.',
            'description_ar' => 'كنبة مريحة لغرفة المعيشة.',
            'price' => 299.99,
            'category_id' => 2,
            'image' => 'products/sofa.jpg', // Dummy image path
        ]);

        Product::create([
            'name_en' => 'Dining Table',
            'name_ar' => 'طاولة طعام',
            'description_en' => 'A wooden dining table.',
            'description_ar' => 'طاولة طعام خشبية.',
            'price' => 399.99,
            'category_id' => 2,
            'image' => 'products/dining_table.jpg', // Dummy image path
        ]);
    }
}
