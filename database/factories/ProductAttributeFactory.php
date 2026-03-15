<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductAttribute>
 */
class ProductAttributeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // SKU: Unique identifier for the specific variant combination
            // Example: PROD123-RED-L-64GB
            'sku' => Str::random(8), // Generate a random SKU, or use a more structured approach if needed

            // Price for this specific attribute combination
            'price' => $this->faker->randomFloat(2, 10, 1000), // Price between 10 and 1000

            // Stock quantity for this specific attribute combination
            'stock' => $this->faker->numberBetween(0, 100), // Stock between 0 and 100

            // You might have other specific attributes here like:
            // 'color' => $this->faker->colorName,
            // 'size' => $this->faker->randomElement(['S', 'M', 'L', 'XL']),
            // 'storage' => $this->faker->randomElement(['64GB', '128GB', '256GB']),
            // These would typically be stored in a JSON or separate attribute table if dynamic
        ];
    }

    /**
     * Configure the factory to create a product attribute that is in stock.
     */
    public function inStock(): static
    {
        return $this->state(fn(array $attributes) => [
            'stock' => $this->faker->numberBetween(1, 100),
        ]);
    }

    /**
     * Configure the factory to create a product attribute that is out of stock.
     */
    public function outOfStock(): static
    {
        return $this->state(fn(array $attributes) => [
            'stock' => 0,
        ]);
    }

    /**
     * Configure the factory to create a product attribute with a specific price.
     */
    public function withPrice(float $price): static
    {
        return $this->state(fn(array $attributes) => [
            'price' => $price,
        ]);
    }
}
