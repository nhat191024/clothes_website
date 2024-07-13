<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\client\HomeController;

Route::get('/', function () {
    return view('client.home');
});
Route::prefix('home')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home.index');
});
