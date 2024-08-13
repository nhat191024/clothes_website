<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Service\client\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private $cartService;
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        return view('client.cart.cart')->with([
            'cart' => $this->cartService->getCart() ?: []
        ]);
    }

    public function getCart()
    {
        return $this->cartService->getCart();
    }

    public function addToCart(Request $request)
    {
        return $this->cartService->storeCart($request->all());
    }

    public function removeFromCart(Request $request)
    {
        return $this->cartService->removeProductByDetailId($request->product_detail_id);
    }

    public function updateQuantity(Request $request)
    {
        return $this->cartService->updateQuantity($request->product_detail_id, $request->quantity);
    }

}
