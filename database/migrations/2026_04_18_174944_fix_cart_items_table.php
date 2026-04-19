<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            // Drop the old foreign key if it exists
            if (Schema::hasColumn('cart_items', 'attribute_id')) {
                $table->dropForeign(['attribute_id']);
                $table->dropColumn('attribute_id');
            }

            // Add sku_id column
            $table->foreignId('sku_id')->after('cart_id')->constrained('product_skus')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropForeign(['sku_id']);
            $table->dropColumn('sku_id');

            // Restore attribute_id if needed
            $table->foreignId('attribute_id')->constrained('product_attributes')->cascadeOnDelete();
        });
    }
};
