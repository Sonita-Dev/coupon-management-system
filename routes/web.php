<?php

use App\Http\Controllers\CouponController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('coupons', CouponController::class);

    Route::get('/coupons-apply', [CouponController::class, 'applyForm'])
        ->name('coupons.apply-form');

    Route::post('/coupons-apply', [CouponController::class, 'apply'])
        ->name('coupons.apply');
});

// When you install Laravel Breeze or other auth scaffolding,
// it will usually add its own auth routes file.
if (file_exists(__DIR__ . '/auth.php')) {
    require __DIR__ . '/auth.php';
}

