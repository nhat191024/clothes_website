<?php

use App\Http\Controllers\Client\ContactController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     // return view('client.home');
// });
Route::prefix('contact')->group(function (){
    Route::get('/',[ContactController::class, 'index'])->name('contact.index');
});