<?php

namespace Database\Seeders;

use App\Models\Attributes;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\VariantCategories;
use App\Models\Variants;
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

        if (Category::count() < 10) {
            Category::factory(10)->create();
        }

        if (Product::count() < 10) {
            Product::factory(10)->create();
        }

        if (VariantCategories::count() < 10) {
            VariantCategories::factory(10)->create();
        }

        if (Variants::count() < 10) {
            Variants::factory(10)->create();
        }

        if (Attributes::count() < 10) {
            Attributes::factory(10)->create();
        }
    }
}
