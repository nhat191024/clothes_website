<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('client.home');
});
Route::get('/AccountManagement', function () {
    return view('AccountManagement.AccountManagement');
});
