<?php
use App\Http\Controllers\admin\AboutUsController;
use App\Http\Controllers\admin\BannerController;
use App\Http\Controllers\admin\BillController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\ColorController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\MessageController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\PromotionController;
use App\Http\Controllers\admin\SizeController;
use App\Http\Controllers\admin\VoucherController;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\client\CheckoutController;
use App\Http\Controllers\client\AboutController;
use App\Http\Controllers\client\AccountManagement;
use App\Http\Controllers\client\CartController;
use App\Http\Controllers\client\ContactController;
use App\Http\Controllers\client\LoginController;
use App\Http\Controllers\client\HomeController;
use App\Http\Controllers\client\RegisterController;
use App\Http\Controllers\client\ShopController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('client.home');
});
