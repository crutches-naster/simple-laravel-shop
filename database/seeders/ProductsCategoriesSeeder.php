<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory(5)
            ->create()
            ->each(function(Category $category) {
                $category->products()->attach(
                    Product::factory(rand(5, 10))
                        ->create()
                        ->pluck('id')
                );
            });
    }
}
