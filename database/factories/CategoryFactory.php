<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "title" => fake()->unique()->name(),
            "subtitle" => fake()->realText(15),
            "image" => "default-box.png",
            "product_qty" => rand(0,5),
            "product_id" => fake()->numberBetween(0,10)
        ];
    }
}
