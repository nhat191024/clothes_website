<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Service\client\CheckoutService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCheckoutRequest;

class CheckoutController extends Controller
{
    private $checkoutService;

    public function __construct()
    {
        $this->checkoutService = new CheckoutService();
    }

    public function index()
    {
        $user = Auth::user();
        $carts =  $this->checkoutService->getProductList();
        $discount = $this->checkoutService->getDiscount();
        $subTotal = $this->checkoutService->getCartSubTotal();
        $total = $this->checkoutService->getCartTotal();

        if (count($carts) == 0 || $carts == null) {
            return redirect()->route('client.home.index');
        }
        return view('client.checkout.checkout', compact('carts', 'user', 'subTotal', 'discount', 'total'));
    }

    public function store(StoreCheckoutRequest $request)
    {
        $response = $this->checkoutService->confirmOrder($request);
        return $response;
    }
}
