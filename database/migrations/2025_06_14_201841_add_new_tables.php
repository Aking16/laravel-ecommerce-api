<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('type_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('variants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('category')->constrained('type_categories')->onDelete('cascade');
            $table->string('color');
            $table->timestamps();
        });

        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('file');
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->foreignId('thumbnail')->nullable()->constrained('galleries')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('category')->constrained('categories')->onDelete('cascade');
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('meta_title')->nullable();
            $table->foreignId('thumbnail')->nullable()->constrained('galleries')->onDelete('set null');
            $table->foreignId('galleries')->nullable()->constrained('galleries')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->integer('price');
            $table->integer('stock');
            $table->integer('discount_number')->nullable();
            $table->integer('discount_percentage')->nullable();
            $table->foreignId('thumbnail')->nullable()->constrained('galleries')->onDelete('set null');
            $table->foreignId('types')->constrained('variants')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->integer('discount_percentage')->nullable();
            $table->integer('discount_number')->nullable();
            $table->string('key')->unique();
            $table->integer('usage_count')->default(0);
            $table->timestamps();
        });

        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('items')->constrained('attributes')->onDelete('cascade');
            $table->foreignId('discount')->nullable()->constrained('discounts')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
        Schema::dropIfExists('discounts');
        Schema::dropIfExists('attributes');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('galleries');
        Schema::dropIfExists('variants');
        Schema::dropIfExists('type_categories');
    }
};
