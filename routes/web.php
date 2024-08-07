<?php


use App\Http\Controllers\client\AccountManagement;

use App\Http\Controllers\client\ContactController;
use App\Http\Controllers\client\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\client\HomeController;

Route::prefix('/')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home.index');
});

// Route::get('/Account', function () {
//     return view('client.Account.AccountManagement');
// });
Route::prefix('/Account')-> group(function () {
    Route::get('/{id}', [AccountManagement::class,'index'])->name('client.account.index');
    Route::get('/ChangePassword/{id}', [AccountManagement::class,'pass'])->name('client.account.changepassword');

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


