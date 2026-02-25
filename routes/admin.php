<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\ContactSubmissionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FabricController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SeoController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\WorkController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest.admin')->group(function () {
        Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->name('login.post');
    });

    Route::middleware('auth.admin')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('media', MediaController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::get('media/browse', [MediaController::class, 'browse'])->name('media.browse');

        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::resource('fabrics', FabricController::class)->except(['show']);
        Route::resource('works', WorkController::class)->except(['show']);
        Route::resource('colors', ColorController::class)->except(['show']);
        Route::resource('products', ProductController::class)->except(['show']);

        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::patch('orders/{order}/payment-status', [OrderController::class, 'updatePaymentStatus'])->name('orders.update-payment-status');

        Route::get('seo', [SeoController::class, 'index'])->name('seo.index');
        Route::get('seo/{pageIdentifier}/edit', [SeoController::class, 'edit'])->name('seo.edit');
        Route::put('seo/{pageIdentifier}', [SeoController::class, 'update'])->name('seo.update');

        // Banners
        Route::resource('banners', BannerController::class)->except(['show']);

        // Site Settings
        Route::get('settings', [SiteSettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [SiteSettingController::class, 'update'])->name('settings.update');
        Route::get('settings/seed', [SiteSettingController::class, 'seed'])->name('settings.seed');

        // Contact Submissions
        Route::get('contact-submissions', [ContactSubmissionController::class, 'index'])->name('contact-submissions.index');
        Route::get('contact-submissions/{contactSubmission}', [ContactSubmissionController::class, 'show'])->name('contact-submissions.show');
        Route::delete('contact-submissions/{contactSubmission}', [ContactSubmissionController::class, 'destroy'])->name('contact-submissions.destroy');
        Route::post('contact-submissions/{contactSubmission}/mark-read', [ContactSubmissionController::class, 'markAsRead'])->name('contact-submissions.mark-read');
        Route::post('contact-submissions/mark-all-read', [ContactSubmissionController::class, 'markAllAsRead'])->name('contact-submissions.mark-all-read');
    });
});
