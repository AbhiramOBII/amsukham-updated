<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

Route::get('/products', function () {
    return view('pages.products');
})->name('products');

Route::get('/product/{id}', function ($id) {
    return view('pages.product-show');
})->name('product.show');

Route::get('/latest-collections', function () {
    return view('pages.latest-collections');
})->name('latest-collections');
