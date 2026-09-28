<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/product/1', function () {
    return view('products.show');
});

Route::get('/category/{slug}', function ($slug) {
    return view('categories.show', ['category' => $slug]);
});
