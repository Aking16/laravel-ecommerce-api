<?php

use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\V1\AttributesController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\ImageController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\VariantCategoriesController;
use App\Http\Controllers\Api\V1\VariantsController;
use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\Api\V1\CartItemsController;
use App\Http\Controllers\Api\V1\PaymentsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [ApiAuthController::class, 'login']);
Route::post('/register', [ApiAuthController::class, 'register'])->name('api.register');

Route::prefix('v1')->group(function () {
    Route::apiResource('product', ProductController::class)->only(['index', 'show']);

    Route::apiResource('category', CategoryController::class)->only(['index', 'show']);

    Route::apiResource('image', ImageController::class)->only(['index', 'show']);
});

Route::prefix('v1')->middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    Route::post('logout', [ApiAuthController::class, 'logout']);

    Route::apiResource('category', CategoryController::class)->except(['index', 'show']);

    Route::apiResource('image', ImageController::class)->except(['index', 'show']);

    Route::apiResource('product', ProductController::class)->except(['index', 'show']);
    Route::apiResource('attributes', AttributesController::class);
    Route::apiResource('variants', VariantsController::class);
    Route::apiResource('variant-categories', VariantCategoriesController::class);

    Route::apiResource('cart-items', CartItemsController::class);
    Route::apiResource('cart', CartController::class);

    Route::apiResource('payments', PaymentsController::class);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
