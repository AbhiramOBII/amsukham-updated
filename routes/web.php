<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RazorpayWebhookController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'submitContact'])->name('contact.submit');
Route::post('/newsletter/subscribe', [HomeController::class, 'subscribeNewsletter'])->name('newsletter.subscribe');
Route::get('/latest-collections', [HomeController::class, 'latestCollections'])->name('latest-collections');

Route::get('/terms-of-service', [HomeController::class, 'terms'])->name('terms');
Route::get('/privacy-policy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/return-policy', [HomeController::class, 'returnPolicy'])->name('return-policy');

Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::get('/category/{slug}', [ProductController::class, 'category'])->name('category.show');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{cart}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
Route::post('/coupon/apply', [CouponController::class, 'apply'])->name('coupon.apply');
Route::post('/coupon/remove', [CouponController::class, 'remove'])->name('coupon.remove');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
Route::post('/checkout/verify', [CheckoutController::class, 'verify'])->name('checkout.verify');
Route::get('/order/success/{orderNumber}', [CheckoutController::class, 'success'])->name('order.success');
Route::get('/order/failure/{orderNumber}', [CheckoutController::class, 'failure'])->name('order.failure');
Route::post('/order/track', [CheckoutController::class, 'trackOrder'])->name('order.track');
Route::get('/orders/{id}', [CheckoutController::class, 'viewOrder'])->name('order.view');

Route::post('/webhooks/razorpay', [RazorpayWebhookController::class, 'handle'])->name('webhooks.razorpay');
