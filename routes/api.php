<?php

use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\V1\AttributesController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\GalleryController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\VariantCategoriesController;
use App\Http\Controllers\Api\V1\VariantsController;
use App\Http\Controllers\Api\V1\CartsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [ApiAuthController::class, 'login']);
Route::post('/register', [ApiAuthController::class, 'register'])->name('api.register');

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::post('logout', [ApiAuthController::class, 'logout']);

    Route::apiResource('category', CategoryController::class);
    Route::apiResource('gallery', GalleryController::class);
    Route::apiResource('product', ProductController::class);
    Route::apiResource('attributes', AttributesController::class);
    Route::apiResource('variants', VariantsController::class);
    Route::apiResource('variant-categories', VariantCategoriesController::class);
    Route::apiResource('carts', CartsController::class);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
