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
        return view('client.cart.cart');
    }

    public function getCart()
    {
        return $this->cartService->getCart();
    }
}
