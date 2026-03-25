<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sku_variant_values', function (Blueprint $table) {
            $table->id();

            $table->foreignId('sku_id')
                ->constrained('product_skus')
                ->cascadeOnDelete();

            $table->foreignId('variant_value_id')
                ->constrained('product_variant_values')
                ->cascadeOnDelete();

            $table->unique(['sku_id', 'variant_value_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sku_variant_values');
    }
};
