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
        Schema::dropIfExists('cart_variant');
        Schema::dropIfExists('attributes');
        Schema::dropIfExists('variants');
        Schema::dropIfExists('variant_categories');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('galleries');
        Schema::dropIfExists('carts');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('discounts');
    }
};
