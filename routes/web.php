<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController as Products;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::prefix('products')->group(function () {
    Route::get('/', [Products::class, 'index'])->name('products.index');
    Route::get('/create', [Products::class, 'create'])->name('products.create');
    Route::post('/', [Products::class, 'store'])->name('products.store');
    Route::get('/{id}/detail', [Products::class, 'show'])->name('products.show');
    Route::get('/{id}/edit', [Products::class, 'edit'])->name('products.edit');
    Route::put('/{id}/update', [Products::class, 'update'])->name('products.update');
});