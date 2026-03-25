<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ProductSku;
use App\Models\ProductVariantValue;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SkuVariantValue>
 */
class SkuVariantValueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sku_id' => ProductSku::factory(),
            'variant_value_id' => ProductVariantValue::factory(),
        ];
    }
}
