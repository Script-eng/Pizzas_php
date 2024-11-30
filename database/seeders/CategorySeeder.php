<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // Category data
        $categories = [
            ['cname' => 'page', 'price' => 850],
            ['cname' => 'nobleman', 'price' => 950],
            ['cname' => 'king', 'price' => 1250],
            ['cname' => 'knight', 'price' => 1150],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
