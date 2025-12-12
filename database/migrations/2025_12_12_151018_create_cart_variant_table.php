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
        Schema::create('cart_variant', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carts_id')
                ->constrained('carts')
                ->onDelete('cascade');

            $table->foreignId('attributes_id')
                ->constrained('attributes')
                ->onDelete('cascade');

            $table->foreignId('discounts_id')
                ->nullable()
                ->constrained('discounts')
                ->nullOnDelete();

            $table->unique(['carts_id', 'variant_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_variant');
    }
};
