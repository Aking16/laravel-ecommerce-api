<?php

namespace Database\Factories;

use App\Models\Attributes;
use App\Models\VariantCategories;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Variants>
 */
class VariantsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'color' => $this->faker->randomElement(['red', 'blue', 'green', 'yellow', 'black', 'white']),
            'variant_categories_id' => VariantCategories::inRandomOrder()->first()?->id ?? VariantCategories::factory(),
        ];
    }
}
