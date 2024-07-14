<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\client\HomeController;

// Route::get('/', function () {
//     return view('client.home.index');
// });
Route::prefix('/')->group(function () {
    Route::get('/', [HomeController::class, 'NewProductsInfo'])->name('home.index');
});
