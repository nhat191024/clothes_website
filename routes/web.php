<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('client.home');
});
Route::get('/Account', function () {
    return view('AccountManagement.AccountManagement');
});
