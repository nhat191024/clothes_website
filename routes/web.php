<?php

use App\Http\Controllers\client\AccountManagement;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('client.home');
});
// Route::get('/Account', function () {
//     return view('client.Account.AccountManagement');
// });
Route::prefix('/Account')-> group(function () {
    Route::get('/{id}', [AccountManagement::class,'index'])->name('client.account.index');
    Route::get('/ChangePassword/{id}', [AccountManagement::class,'pass'])->name('client.account.changepassword');

});
