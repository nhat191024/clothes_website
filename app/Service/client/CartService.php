<?php

namespace App\Service\client;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartService
{
    public function getAll()
    {
        return Cart::all();
    }

    public function getCart()
    {
        return Cart::where('user_id', Auth::user()->id)->get();
    }

    public function storeCart($data)
    {
        return Cart::create($data);
    }
}
