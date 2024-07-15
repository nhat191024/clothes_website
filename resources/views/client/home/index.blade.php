
@extends('client.layout')
@section('main')
   <!-- Categories Section Begin -->
    <section class="categories">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 p-0">
                    <div class="categories__item categories__large__item set-bg"
                    data-setbg="{{ asset($productAmount[0]->img) }}">
                    <div class="categories__text">
                        <h1 style="font-family: 'Times New Roman', Times, serif, fantasy"> Thời trang {{ $productAmount[0]->name }}</h1>
                        <p>{{ $productAmount[0]->product_amount }} items</p>
                        <a href="#">Shop now</a>
                    </div>
                </div>
            </div>
            @php $productAmount->forget(0) @endphp
            <div class="col-lg-6">
                <div class="row">
                    @foreach($productAmount as $category)
                    <div class="col-lg-6 col-md-6 col-sm-6 p-0">
                        <div class="categories__item set-bg" data-setbg="{{ asset($category->img) }}">
                            <div class="categories__text">
                                <h4 style="font-family: 'Times New Roman', Times, serif, fantasy;">Thời trang {{ $category->name }}</h4>
                                <p>{{ $category->product_amount }} items</p>
                                <a href="#">Shop now</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Categories Section End -->

<!-- Product Section Begin -->
<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="section-title">
                    <h4>New product</h4>
                </div>
            </div>
            <div class="col-lg-8 col-md-8">
                <ul class="filter__controls">
                    <li class="active" data-filter="*">All</li>
                    <li data-filter=".Nữ">Women’s</li>
                    <li data-filter=".Nam">Men’s</li>
                    <li data-filter=".Trẻ em">Kid’s</li>
                    <li data-filter=".Unisex">Unisex</li>
                    {{-- <li data-filter=".cosmetic">Cosmetics</li> --}}
                </ul>
            </div>
        </div>
        <div class="row property__gallery">
            @foreach($newProductInfo as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 mix @foreach($product->categories as $category){{ $category->name }} @endforeach ">       
                <div class="product__item">
                    <div class="product__item__pic set-bg" data-setbg="{{ asset($product->img) }}">
                        <div class="label new">New</div>
                        <ul class="product__hover">
                            <li><a href="{{ asset($product->img) }}" class="image-popup"><span class="arrow_expand"></span></a></li>
                            <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                            <li><a href="#"><span class="icon_bag_alt"></span></a></li>
                        </ul>
                    </div>
                    <div class="product__item__text">
                        <h6><a href="#">{{ $product->name }}</a></h6>
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="product__price">{{ number_format((int) $product->price, 0) }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Product Section End -->

<!-- Banner Section Begin -->
<section class="banner set-bg" data-setbg="{{ asset($collectionBanner[0]->image) }}">
    <div class="container">
        <div class="row">
            <div class="col-xl-7 col-lg-8 m-auto">
                <div class="banner__slider owl-carousel">
                    @foreach($collectionBanner as $banner)
                    <div class="banner__item">
                        <div class="banner__text">
                            <span>{{ $banner->title }}</span>
                            <h1>{{ $banner->subtitle  }}</h1>
                            <a href="{{ $banner->link }}">Shop now</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Banner Section End -->

<!-- Trend Section Begin -->
<section class="trend spad">
    <div class="container">
        <div class="row">
            @php
                $count = 0;
                $sections = ['Hot Trend', 'Best Seller'];
            @endphp
            @foreach($trendProductInfo as $product)
                @if($count % 3 == 0)
                    @if($count != 0)
                        </div>
                    </div>
                    @endif
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <div class="trend__content">
                            <div class="section-title">
                                <h4>{{ $sections[$count / 3] ?? 'Other Products' }}</h4>
                            </div>
                @endif
                <div class="trend__item">
                    <div class="trend__item__pic">
                        <img src="{{$product->img}}" alt="" width="100px">
                    </div>
                    <div class="trend__item__text">
                        <h6>{{ $product->name }}</h6>
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="product__price">{{ number_format((int) $product->price, 0) }} VND</div>
                    </div>
                </div>
                @php $count++ @endphp
            @endforeach
            @if($count % 3 != 0)
                </div>
            </div>
            @endif
        </div>
    </div>
          <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="trend__content">
                    <div class="section-title">
                        <h4>Favorite</h4>
                    </div>
                    @foreach($favoriteProductInfo as $product)
                    <div class="trend__item">
                        <div class="trend__item__pic">
                            <img src="{{$product->img}}" alt="" width="100px">
                        </div>
                        <div class="trend__item__text">
                            <h6>{{ $product->name }}</h6>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="product__price">{{ number_format((int) $product->price, 0) }} VND</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Trend Section End -->

<!-- Discount Section Begin -->
<section class="discount">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 p-0">
                <div class="discount__pic">
                    <img src="img/discount.jpg" alt="">
                </div>
            </div>
            <style>
                .countdown__item {
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                }
            </style>
            <div class="col-lg-6 p-0">
                <div class="discount__text">
                    <div class="discount__text__title">
                        <span>Discount</span>
                        <h2>{{ $latestPromotion->description }}</h2>
                        <h5><span>Sale</span> {{ $latestPromotion->discount_percentage }}%</h5>
                    </div>
                    <div class="discount__countdown" id="countdown-time">
                        <div class="countdown__item">
                            <span id="days">{{ $latestPromotion->daysDiff }}</span>
                            <p>Days</p>
                        </div>
                        <div class="countdown__item">
                            <span id="hours">{{ $latestPromotion->hoursDiff }}</span>
                            <p>Hours</p>
                        </div>
                        <div class="countdown__item">
                            <span id="minutes">{{ $latestPromotion->minsDiff }}</span>
                            <p>Minutes</p>
                        </div>
                        <div class="countdown__item">
                            <span id="seconds">{{ $latestPromotion->secsDiff }}</span>
                            <p>Seconds</p>
                        </div>
                    </div>
                                        <a href="#">Shop now</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Discount Section End -->

<!-- Services Section Begin -->
<section class="services spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="services__item">
                    <i class="fa fa-car"></i>
                    <h6>Free Shipping</h6>
                    <p>For all oder over $99</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="services__item">
                    <i class="fa fa-money"></i>
                    <h6>Money Back Guarantee</h6>
                    <p>If good have Problems</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="services__item">
                    <i class="fa fa-support"></i>
                    <h6>Online Support 24/7</h6>
                    <p>Dedicated support</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="services__item">
                    <i class="fa fa-headphones"></i>
                    <h6>Payment Secure</h6>
                    <p>100% secure payment</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Services Section End -->
@endsection

