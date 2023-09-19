<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            "title" => fake()->name(),
            "description" => fake()->realText(30),
            "price" => rand(50,1000),
            "image" => "default-box.png",
            "gallery" => ["default-box.png"],
            "quantity" => rand(0,10),
            "discount" => rand(50,100),
            "size" => fake()->randomElement(['sm','md','lg','xl','2xl','3xl']),
            "category_id" => fake()->numberBetween(0,5)
        ];
    }
}
