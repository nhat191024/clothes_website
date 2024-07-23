<?php

use App\Http\Controllers\client\ContactController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\client\HomeController;

Route::prefix('/')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home.index');
});

Route::prefix('contact')->group(function () {
    Route::get('/', [ContactController::class, 'index'])->name('client.contact.index');
    Route::post('/', [ContactController::class, 'store'])->name('customer.requests.store');
});

