<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantValue;
use App\Models\ProductSku;
use App\Models\SkuVariantValue;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ساخت یوزر تست
        User::firstOrCreate(
            ['email' => 'test@gmail.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('12345678'),
                'is_admin' => true
            ]
        );

        Category::factory(5)->create()->each(function ($category) {
            $products = Product::factory(3)->create([
                'category_id' => $category->id
            ]);

            foreach ($products as $product) {
                $variants = ProductVariant::factory()
                    ->count(2)
                    ->create([
                        'product_id' => $product->id
                    ]);

                $variantValues = collect();

                foreach ($variants as $variant) {
                    $values = ProductVariantValue::factory()
                        ->count(3)
                        ->create([
                            'variant_id' => $variant->id
                        ]);

                    $variantValues[$variant->id] = $values;
                }

                $skus = ProductSku::factory(4)->create([
                    'product_id' => $product->id
                ]);

                foreach ($skus as $sku) {
                    foreach ($variants as $variant) {
                        SkuVariantValue::create([
                            'sku_id' => $sku->id,
                            'variant_value_id' => $variantValues[$variant->id]->random()->id
                        ]);
                    }
                }
            }
        });
    }
}
