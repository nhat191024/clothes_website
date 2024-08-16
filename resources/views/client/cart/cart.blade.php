@extends('client.layout')
@section('main')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="{{ route('client.home.index') }}"><i class="fa fa-home"></i> Home</a>
                        <span>Shopping cart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Shop Cart Section Begin -->
    <section class="shop-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shop__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cart as $pd)
                                <tr class="product-{{ $pd['product_detail_id'] }}">
                                    <td class="cart__product__item">
                                        <img width="80px" src="{{ url('').'/'.$pd['productDetail']->product->img }}" alt="">
                                        <div class="cart__product__item__title">
                                            <h6>{{ $pd['productDetail']->product->name }}</h6>
                                            <div class="rating"><span style="display: inline-block; width: 15px; height: 15px; border-radius: 50%; transform: translateY(3px); background-color: {{ $pd['productDetail']->color->color_hex ?? 'black' }};"></span>
                                                <i class="fa fa-sta font-weight-bold" style="font-size: 15px;color: black">Color: {{ $pd['productDetail']->color->name }} - Size: {{ $pd['productDetail']->size->name }}</i>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="cart__price cart__price-{{ $pd['product_detail_id'] }}" data-id="{{ $pd['productDetail']->product->price }}">¥{{ number_format($pd['productDetail']->product->price) }}</td>
                                    <td class="cart__quantity">
                                        <div class="pro-qty">
                                            <input id="productDetail-{{ $pd['product_detail_id'] }}" name="product-quantity" type="text" value="{{ $pd['quantity'] }}">
                                        </div>
                                    </td>
                                    <td class="cart__total" id="cart__total-{{ $pd['product_detail_id'] }}">¥{{ number_format($pd['productDetail']->product->price * $pd['quantity']) }}</td>
                                    <td class="cart__close_{{ $pd['product_detail_id'] }}" onclick="removeFromCart({{ $pd['product_detail_id'] }})" style="cursor: pointer"><span class="icon_close"></span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="cart__btn">
                        <a href="{{ route('client.shop.index') }}">Continue Shopping</a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="cart__btn update__btn">
                        <a href="{{ route('client.cart.index') }}"><span class="icon_loading"></span> Update cart</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="discount__content">
                        <h6>Discount codes</h6>
                        <form action="#">
                            <input type="text" id="voucher_code" placeholder="Enter your voucher code">
                            <button type="submit" id="apply_voucher" class="site-btn">Apply</button>
                        </form>
                        <div id="voucher_error" class="text-danger ml-3"></div>
                    </div>
                </div>
                <div class="col-lg-4 offset-lg-2">
                    <div class="cart__total__procced">
                        <h6>Cart total</h6>
                        <ul>
                            <li>Subtotal
                                <span id="subtotal">
                                    ¥{{ number_format($subtotal) }}
                                </span>
                            </li>
                            <li id="voucher_label" class="{{ $voucher == null|| ($voucher ? $voucher->discount_percentage : 0) == 0 ? 'd-none' : '' }}">Voucher
                                <span id="voucher">
                                    -¥{{ number_format($subtotal * ($voucher ? $voucher->discount_percentage : 0) / 100 ) }}
                                </span>
                            </li>
                            <li>Total
                                <span id="total">
                                    ¥{{ number_format($subtotal - ($subtotal * ($voucher ? $voucher->discount_percentage : 0) / 100))  }}
                                </span>
                            </li>
                        </ul>
                        <a href="{{ route('client.checkout.index') }}" class="primary-btn">Proceed to checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Cart Section End -->
    <link rel="stylesheet" href="{{ asset('css/cart/cart.css') }}"></link>
    <script src="{{ url('') . '/' }}js/jquery-3.3.1.min.js"></script>
    <script src="{{ url('') . '/' }}js/cart/cart.js"></script>
@endsection
