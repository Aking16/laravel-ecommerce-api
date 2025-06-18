<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Gallery;
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
            'name' => $this->faker->words(2, true),
            'description' => $this->faker->paragraph(),
            'meta_title' => $this->faker->words(2, true),
            'meta_keywords' => $this->faker->words(2, true),
            'meta_description' => $this->faker->paragraph(),
            'categories_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'galleries_id' => Gallery::inRandomOrder()->first()?->id ?? Gallery::factory(),
        ];
    }
}
