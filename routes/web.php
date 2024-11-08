<?php

use App\Http\Middleware\CheckOTP;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\userController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\productsController;

Route::controller(AuthController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/', 'showLogin')->name('login');
        Route::post('/home', 'login')->name('postLogin');
    });
    Route::middleware('auth')->group(function () {
        Route::post('/update-email', 'updateEmail')->name('updateEmail');
        Route::get('/user/reset-email', 'showResetEmail')->name('showResetEmail');
        Route::get('/logout', 'logout')->name('logout');
    });

    Route::middleware('signed')->group(function () {
        Route::get('/reset-email/{user}', 'confimEmail')->name('confirmEmail');

    });

    Route::middleware(['auth', CheckOTP::class  ])->group(function () {
        Route::get('/verify', 'showVerify')->name('verify');
        Route::post('/verify', 'verifyOTP')->name('postVerify');
        Route::post('/verify-otp', 'verifySendOTP')->name('verifySendOTP');
    });

});

Route::controller(MainController::class)->group(function () {
    Route::get('/home',  'homeShow')->name('home');
    Route::get('/product/{slug}', 'productShow')->name('product');
    Route::get('/store/{toko}', 'profileShow')->name('profile');
});

Route::controller(userController::class)->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/user/account/profile', 'myProfile')->name('profile');
        Route::post('/user/account/profile', 'updateProfile')->name('updateProfile');
        
    });

});

Route::middleware('auth')->group(function () {
    Route::get('/user/store', [productsController::class,'mystore'])->name('myStore');

    Route::get('/user/store/create-product', [productsController::class, 'showAddProduct'])->name('createProduct');
    Route::post('/user/store/create', [productsController::class, 'addProduct'])->name('addProduct');

    Route::get('/user/cart', [CartController::class, 'show'])->name('showCart');
    Route::post('/user/cart', [CartController::class, 'addToCart'])->name('store');
    Route::post('/user/cart/check', [CartController::class, 'buy'])->name('buy');
    Route::delete('/user/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    
    Route::get('/orders/status-update', [OrderController::class, 'updateOrderStatus'])->name('orders.updateStatus');

    Route::post('user/checkout/select', [OrderController::class, 'checkout'])->name('checkout.selected');

    Route::get('/user/checkout', [OrderController::class, 'checkout'])->name('checkout.index');
    Route::post('/user/checkout', [OrderController::class, 'placeOrder'])->name('orders.placeOrder');


    Route::get('/user/purchase', [OrderController::class, 'showPurchase'])->name('purchase.showPurchase');
    Route::get('/user/success', [OrderController::class, 'paymentSuccess'])->name('success');

});
