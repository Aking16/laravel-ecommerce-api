<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gallery>
 */
class GalleryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $file = $this->faker->randomElement([
            'placeholders/man-shirt.jpg',
            'placeholders/t-shirt-1.jpg',
            'placeholders/t-shirt-2.jpg',
        ]);

        return [
            'name' => $this->faker->words(2, true),
            'file' => $file,
        ];
    }
}
