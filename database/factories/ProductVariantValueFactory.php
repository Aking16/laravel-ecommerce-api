<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ProductVariant;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductVariantValue>
 */
class ProductVariantValueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'variant_id' => ProductVariant::factory(),
            'value' => $this->faker->randomElement([
                'Red',
                'Blue',
                'Green',
                'S',
                'M',
                'L',
                '256GB',
                '512GB',
                'Cotton',
                'Leather',
            ]),
        ];
    }
}
