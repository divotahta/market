<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        if (Category::count() === 0) {
            $this->call(CategorySeeder::class);
        }

        $categories = Category::all();

        $products = [
            [
                'name' => 'iPhone 14 Pro Max 256GB',
                'description' => 'iPhone 14 Pro Max bekas kondisi 98%, fullset lengkap, garansi iBox masih aktif. Baterai health 97%, tidak ada minus.',
                'price' => 16500000,
                'condition' => 'Bekas - Seperti Baru',
                'image' => 'products/default.jpg',
                'category_id' => Category::where('name', 'Iphone')->first()?->id ?? Category::where('name', 'Lainnya')->first()->id
            ],
            [
                'name' => 'Samsung Galaxy S23 Ultra',
                'description' => 'Samsung S23 Ultra bekas kondisi 95%, fullset, garansi SEIN. RAM 12/256GB, warna Phantom Black.',
                'price' => 14000000,
                'condition' => 'Bekas - Mulus',
                'image' => 'products/default.jpg',
                'category_id' => Category::where('name', 'Samsung')->first()?->id ?? Category::where('name', 'Lainnya')->first()->id
            ],
            [
                'name' => 'Xiaomi 13 Pro',
                'description' => 'Xiaomi 13 Pro bekas kondisi 96%, fullset, garansi resmi. Snapdragon 8 Gen 2, RAM 12/256GB.',
                'price' => 8500000,
                'condition' => 'Bekas - Seperti Baru',
                'image' => 'products/default.jpg',
                'category_id' => Category::where('name', 'Xiaomi')->first()?->id ?? Category::where('name', 'Lainnya')->first()->id
            ],
            [
                'name' => 'Oppo Find X6 Pro',
                'description' => 'Oppo Find X6 Pro bekas kondisi 97%, lengkap dengan garansi resmi. RAM 12/256GB, kamera Hasselblad.',
                'price' => 9500000,
                'condition' => 'Bekas - Seperti Baru',
                'image' => 'products/default.jpg',
                'category_id' => Category::where('name', 'Oppo')->first()?->id ?? Category::where('name', 'Lainnya')->first()->id
            ],
            [
                'name' => 'Vivo X90 Pro',
                'description' => 'Vivo X90 Pro bekas kondisi 94%, fullset dengan garansi. RAM 12/256GB, kamera Zeiss.',
                'price' => 7800000,
                'condition' => 'Bekas - Mulus',
                'image' => 'products/default.jpg',
                'category_id' => Category::where('name', 'Vivo')->first()?->id ?? Category::where('name', 'Lainnya')->first()->id
            ],
            [
                'name' => 'Samsung Galaxy A54',
                'description' => 'Samsung Galaxy A54 bekas kondisi 95%, fullset, garansi resmi. RAM 8/256GB, warna Phantom Black.',
                'price' => 6500000,
                'condition' => 'Bekas - Mulus',
                'image' => 'products/default.jpg',
                'category_id' => Category::where('name', 'Samsung')->first()?->id ?? Category::where('name', 'Lainnya')->first()->id
            ]
            
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
