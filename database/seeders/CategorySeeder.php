<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    
    public function run()
    {
        Category::create([
            'name_en' => 'Electronics',
            'name_ar' => 'إلكترونيات',
        ]);

        Category::create([
            'name_en' => 'Furniture',
            'name_ar' => 'أثاث',
        ]);
    }
}
