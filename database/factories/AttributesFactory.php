<?php

namespace Database\Factories;

use App\Models\Gallery;
use App\Models\Variants;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attributes>
 */
class AttributesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'price' => $this->faker->numberBetween(1000, 100000),
            'stock' => $this->faker->numberBetween(0, 100),
            'discount_number' => $this->faker->randomElement([
                $this->faker->numberBetween(0, 50),
                null
            ]),
            'discount_percentage' => $this->faker->randomElement([
                $this->faker->numberBetween(0, 100),
                null
            ]),
            'variants_id' => Variants::inRandomOrder()->first()?->id ?? Variants::factory(),
            'galleries_id' => Gallery::inRandomOrder()->first()?->id ?? Gallery::factory(),
        ];
    }
}
