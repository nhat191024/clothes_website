@extends('client.layout')
@section('main')
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__left product__thumb nice-scroll">
                            @foreach ($product->image as $img)
                                <a class="pt active" href="#img-{{ $loop->index }}">
                                    <img src="{{ url('') . '/' }}{{ $img->img }}" alt="">
                                </a>
                            @endforeach
                        </div>
                        <div class="product__details__slider__content">
                            <div class="product__details__pic__slider owl-carousel">
                                <img data-hash="img-1" class="product__big__img"
                                    src="{{ url('') . '/' }}{{ $product->img }}" alt="">
                                @foreach ($product->image as $img)
                                    <img data-hash="img-{{ $loop->index }}" class="product__big__img"
                                        src="{{ url('') . '/' }}{{ $img->img }}" alt="">
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="product__details__text">
                        <h3>{{ $product->name }}
                            <span>Suitable for: @foreach ($product->categories as $ct)
                                {{ $ct->name }}@if (!$loop->last),@endif
                                @if ($loop->index == 3)...@break @endif @endforeach
                            </span>
                        </h3>
                    <div class="product__details__price"><i class="fa fa-fw fa-yen"></i>{{ $product->price }} <span><i
                                class="fa fa-fw fa-yen"></i>{{ $product->price + 20000 }}</span> </div>
                    <p>The estimated delivery time is 3-7 business days.</p>
                    <div class="product__details__button">
                        <div class="quantity">
                            <span>Quantity:</span>
                            <div class="pro-qty">
                                <input type="text" value="1">
                            </div>
                        </div>
                        <a href="#" class="cart-btn"><span class="icon_bag_alt"></span> Add to cart</a>
                    </div>
                    <div class="product__details__widget">
                        <ul>
                            <li>
                                <span>Available color:</span>
                                <div class="color__checkbox">
                                    @foreach ($product->productDetail->unique('color') as $prodDetail)
                                        {{ $prodDetail->color->color_name }}
                                        <label for="{{ $prodDetail->color->id }}">
                                            <input type="radio" name="color__radio" id="{{ $prodDetail->color->id }}"
                                                @if ($loop->index == 0) checked @endif>
                                            <span class="checkmark"
                                                style="background-color: {{ $prodDetail->color->color_hex }};"></span>
                                        </label>
                                    @endforeach
                                </div>
                            </li>
                            <li>
                                <span>Available size:</span>
                                <div class="size__btn">
                                    @foreach ($product->productDetail->unique('size') as $prodDetail)
                                        <label for="{{ $prodDetail->size->id }}"
                                            class="font-weight-bold @if ($loop->index == 0) active @endif">
                                            <input name="size" type="radio" id="{{ $prodDetail->size->id }}">
                                            {{ $prodDetail->size->name }}
                                        </label>
                                    @endforeach
                                </div>
                            </li>
                            <li>
                                <span>Promotions:</span>
                                <p>Free shipping</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="product__details__tab">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Description</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabs-1" role="tabpanel">
                            <p>{{ $product->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="related__title">
                    <h5>RELATED PRODUCTS</h5>
                </div>
            </div>
            @foreach ($product->categories[0]->products->shuffle() as $relatedProduct)
                @if ($loop->index == 4)
                    @break
                @endif
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="{{ asset($relatedProduct->img) }}">
                            <ul class="product__hover">
                                <li><a href="{{ url('') . '/' }}{{ $relatedProduct->img }}" class="image-popup"><span
                                            class="arrow_expand"></span></a></li>
                                <li><a href="{{ route('client.shop.detail', ['id' => $relatedProduct->id]) }}"><span class="icon_bag_alt"></span></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="{{ route('client.shop.detail', ['id' => $relatedProduct->id]) }}">{{ $relatedProduct->name }}</a></h6>
                            <div class="product__price">¥ {{ $relatedProduct->price }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <link rel="stylesheet" href="{{ asset('css/shop/productDetail.css') }}">
    </link>
    <script src="{{ url('') . '/' }}js/jquery-3.3.1.min.js"></script>
    <script src="{{ url('') . '/' }}js/shop/productDetail.js"></script>
</section>
@endsection
