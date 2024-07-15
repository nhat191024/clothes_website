<?php

use App\Http\Controllers\client\ContactController;
use App\Http\Controllers\Client\CustomerRequestController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('client.home');
// });
Route::prefix('contact')->group(function () {
    Route::get('/', [ContactController::class, 'index'])->name('client.contact.index');
    Route::post('/', [CustomerRequestController::class, 'store'])->name('customer.requests.store');
});