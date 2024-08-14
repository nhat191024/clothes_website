<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Service\client\CartService;
use App\Service\client\CartSessionService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private $cartService;
    private $cartSessionService;
    private $isLoggedIn;
    private $cart;
    public function __construct(CartService $cartService,CartSessionService $cartSessionService)
    {
        $this->cartService = $cartService;
        $this->cartSessionService = $cartSessionService;
        $this->isLoggedIn = Auth::check();
        $cart = ($this->isLoggedIn) ?
            $this->cartService->getCart() :
                $this->cartSessionService->getCart();
        $this->cart = $cart;
    }

    public function index()
    {
        return view('client.cart.cart')->with([
            'cart' => $this->cart
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

}
