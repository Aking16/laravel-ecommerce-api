<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\ProductVariant;
use App\Models\ProductAttribute;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate(
            ['email' => 'test@gmail.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('12345678'),
                'is_admin' => true
            ]
        );

        Category::factory(5)
            ->has(
                Product::factory(3)
                    ->has(
                        ProductVariant::factory(2)
                            ->has(
                                ProductAttribute::factory(3),
                                'attributes'
                            ),
                        "variants"
                    )
            )
            ->create();
    }
}
