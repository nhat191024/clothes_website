<?php

use App\Http\Controllers\client\ContactController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('client.home');
// });
Route::get('/contact',[ContactController::class, 'index'])->name('contact.index');