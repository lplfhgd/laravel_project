<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        Category::create(['name' => 'برمجة']);
        Category::create(['name' => 'تسويق']);
        Category::create(['name' => 'صيانة']);
    }
}
