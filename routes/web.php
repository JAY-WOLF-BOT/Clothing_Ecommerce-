<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\BagController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::resource('products', AdminProductController::class)->except(['show']);
});

Route::get('/category/{category:slug}', CategoryController::class)->name('category.show');

Route::get('/product/{product:slug}', ProductController::class)->name('product.show');

Route::get('/bag', [BagController::class, 'index'])->name('bag.index');
Route::post('/bag', [BagController::class, 'store'])->name('bag.store');
Route::patch('/bag/{line}', [BagController::class, 'update'])->name('bag.update')->where('line', '.*');
Route::delete('/bag/{line}', [BagController::class, 'destroy'])->name('bag.destroy')->where('line', '.*');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
