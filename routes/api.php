<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::post('/', [ProductController::class, 'store']);
    Route::get('/{id}/detail', [ProductController::class, 'show']);
    Route::put('/{id}/update', [ProductController::class, 'update']);
    Route::delete('/{id}/delete', [ProductController::class, 'destroy']);
});
