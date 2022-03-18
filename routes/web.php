<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GetProductController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class,'index'])->name('home');

    /**
     * Products
     */
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class,'index'])->name('index');
        Route::get('/create', [ProductController::class,'create'])->name('create');
        Route::post('/store', [ProductController::class,'store'])->name('store');
        Route::get('/edit/{product}', [ProductController::class,'edit'])->name('edit');
        Route::put('/update/{product}', [ProductController::class,'update'])->name('update');
        Route::delete('delete/{product}', [ProductController::class,'destroy'])->name('destroy');

        Route::get('/all',GetProductController::class)->name('all');
    });
});
