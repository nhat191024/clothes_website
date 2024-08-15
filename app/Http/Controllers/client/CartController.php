<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Service\client\VoucherService;
use Illuminate\Support\Facades\Auth;
use App\Service\client\CartService;
use App\Service\client\CartSessionService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private $cartService;
    private $cartSessionService;
    private $voucherService;
    private $isLoggedIn;
    private $cart;
    public function __construct(CartService $cartService,CartSessionService $cartSessionService,VoucherService $voucherService)
    {
        $this->cartService = $cartService;
        $this->cartSessionService = $cartSessionService;
        $this->voucherService = $voucherService;
        $this->isLoggedIn = Auth::check();
        $cart = ($this->isLoggedIn) ?
            $this->cartService->getCart() :
                $this->cartSessionService->getCart();
        $this->cart = $cart;
    }

    public function index()
    {
        $subtotal = ($this->isLoggedIn) ?
            $this->cartService->getSubtotal() :
                $this->cartSessionService->getSubtotal();
        $appliedVoucher = $this->voucherService->getActivatedVoucher($subtotal);
        return view('client.cart.cart')->with([
            'cart' => $this->cart,
            'subtotal' => $subtotal,
            'total' => $subtotal - ($subtotal * ($appliedVoucher ? $appliedVoucher->discount_percentage : 0) / 100),
            'voucher' => $appliedVoucher
        ]);
    }

    public function getCart()
    {
        return $this->cart;
    }

    public function addToCart(Request $request)
    {
        return ($this->isLoggedIn) ?
            $this->cartService->storeCart($request->all()) :
                $this->cartSessionService->storeCart($request->all());
    }

    public function removeFromCart(Request $request)
    {
        return ($this->isLoggedIn) ?
            $this->cartService->removeProductByDetailId($request->product_detail_id) :
                $this->cartSessionService->removeProductByDetailId($request->product_detail_id);
    }

    public function updateQuantity(Request $request)
    {
        return ($this->isLoggedIn) ?
            $this->cartService->updateQuantity($request->product_detail_id, $request->quantity) :
                $this->cartSessionService->updateQuantity($request->product_detail_id, $request->quantity);
    }

    public function applyVoucher(Request $request)
    {
        $subtotal = ($this->isLoggedIn) ?
            $this->cartService->getSubtotal() :
                $this->cartSessionService->getSubtotal();
        return $this->voucherService->applyVoucher($request->input('voucher_code'), $subtotal);
    }

    public function getDiscount()
    {
        return $this->voucherService->getDiscountAmount($this->cartSessionService->getSubtotal());
    }
}
