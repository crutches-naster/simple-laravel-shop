<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->words(rand(1, 3), true);

        return [
            'title' => $title,
            'slug' => Str::of($title)->slug('-'),
            'description' => fake()->sentences(rand(1, 5), true),
            'sku' => fake()->unique()->ean13(),
            'base_price' => fake()->randomFloat(2, 10, 100),
            'discount' => rand(0, 90),
            'quantity' => rand(0, 15),
            'thumbnail_url' => fake()->imageUrl()
        ];
    }
}
