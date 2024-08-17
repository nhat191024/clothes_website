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

    public function __construct()
    {
        $this->cartService =  new cartService;
        $this->cartSessionService = new cartSessionService;
        $this->voucherService = new voucherService;
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
        $discount = $this->voucherService->getDiscountAmount($subtotal);
        return view('client.cart.cart')->with([
            'cart' => $this->cart,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $subtotal - $discount,
            'voucher' => $appliedVoucher
        ]);
    }

    public function getCart()
    {
        return $this->cart;
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'color_id' => 'required|integer',
            'size_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        return ($this->isLoggedIn) ?
            $this->cartService->storeCart($request->all()) :
            $this->cartSessionService->storeCart($request->all());
    }

    public function removeFromCart(Request $request)
    {
        $request->validate([
            'product_detail_id' => 'required|integer',
        ]);

        return ($this->isLoggedIn) ?
            $this->cartService->removeProductByDetailId($request->product_detail_id) :
            $this->cartSessionService->removeProductByDetailId($request->product_detail_id);
    }

    public function updateQuantity(Request $request)
    {
        $request->validate([
            'product_detail_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        return ($this->isLoggedIn) ?
            $this->cartService->updateQuantity($request->product_detail_id, $request->quantity) :
            $this->cartSessionService->updateQuantity($request->product_detail_id, $request->quantity);
    }

    public function applyVoucher(Request $request)
    {
        $subtotal = ($this->isLoggedIn) ?
            $this->cartService->getSubtotal() :
            $this->cartSessionService->getSubtotal();
        return $this->voucherService->applyVoucher($request->voucher_code, $subtotal);
    }

    public function getDiscount()
    {
        return $this->voucherService->getDiscountAmount(
            ($this->isLoggedIn) ?
                $this->cartService->getSubtotal() :
                    $this->cartSessionService->getSubtotal()
        );
    }

    public function resetCart()
    {
        ($this->isLoggedIn) ?
            $this->cartService->clearCart() :
            $this->cartSessionService->clearCart();
        return redirect()->route('client.cart.index');
    }
}
