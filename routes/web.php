<?php
use App\Http\Controllers\client\AccountManagement;
use App\Http\Controllers\CartController;
use App\Http\Controllers\client\CheckoutController;
use App\Http\Controllers\client\ContactController;
use App\Http\Controllers\client\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\client\HomeController;
use App\Http\Controllers\client\ShopController;

Route::prefix('/')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('client.home.index');
});

Route::prefix('shop')->group(function () {
    Route::get('/', [ShopController::class, 'index'])->name('client.shop.index');
    Route::get('/filter-products', [ShopController::class, 'filterProducts']);
    Route::get('/product/{id}', [ShopController::class, 'detailProduct'])->name('client.shop.detail');
});

Route::middleware('auth')->prefix('account')-> group(function () {
    Route::get('/', [AccountManagement::class,'index'])->name('client.account.index');
    Route::post('/', [AccountManagement::class,'changeData']);
    Route::get('/changePassword', [AccountManagement::class,'pass'])->name('client.account.changepassword');
    Route::post('/changePassword', [AccountManagement::class,'changePass']);
});

Route::prefix('contact')->group(function () {
    Route::get('/', [ContactController::class, 'index'])->name('client.contact.index');
    Route::post('/', [ContactController::class, 'store'])->name('customer.requests.store');
});

Route::prefix('user')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('client.login.index');
    Route::get('/logout', [LoginController::class, 'logout'])->name('client.logout');
    Route::post('/login/check', [LoginController::class, 'login'])->name('client.login');
});


