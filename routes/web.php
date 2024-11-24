<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController as Products;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::prefix('products')->group(function () {
    Route::get('/', [Products::class, 'index'])->name('products.index');
    Route::get('/create', [Products::class, 'create'])->name('products.create');
    Route::post('/store', [Products::class, 'store'])->name('products.store');
});