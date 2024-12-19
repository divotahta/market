<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Iphone',
            'Samsung',
            'Oppo',
            'Vivo',
            'Xiaomi',
            'Realme',
            'Redmi',
            'Huawei',
            'Infinix',
            'Lainnya',
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => Str::slug($category),
            ]);
        }
    }
} 