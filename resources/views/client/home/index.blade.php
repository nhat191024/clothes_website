
@extends('client.layout')
@section('main')
   <!-- Phần Danh Mục Bắt Đầu -->
    <section class="categories">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 p-0">
                    <div class="categories__item categories__large__item set-bg"
                    data-setbg="{{ asset($productAmount[0]->img) }}">
                    <div class="categories__text">
                        <h1 style="font-family: 'Times New Roman', Times, serif, fantasy"> Thời trang {{ $productAmount[0]['name'] }}</h1>
                        <p>{{ count($productAmount) }} sản phẩm</p>
                        {{-- <p>0 sản phẩm</p> --}}
                        <a href="{{ route('client.shop.index') }}">Mua ngay</a>
                    </div>
                </div>
            </div>
            @php $productAmount->forget(0) @endphp
            <div class="col-lg-6">
                <div class="row">
                    @foreach($productAmount as $ct)
                    <div class="col-lg-6 col-md-6 col-sm-6 p-0">
                        <div class="categories__item set-bg" data-setbg="{{ asset($ct->image) }}">
                            <div class="categories__text">
                                <h4 style="font-family: 'Times New Roman', Times, serif, fantasy;">Thời trang {{ strtolower($ct->name) }}</h4>
                                <p>{{ count($productAmount) }} sản phẩm</p>
                                {{-- <p>0 sản phẩm</p> --}}
                                <a href="{{ route('client.shop.index') }}">Mua ngay</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Phần Danh Mục Kết Thúc -->

<!-- Phần Sản Phẩm Bắt Đầu -->
<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="section-title">
                    <h4>Sản phẩm mới</h4>
                </div>
            </div>
            <div class="col-lg-8 col-md-8">
                <ul class="filter__controls">
                    <li class="active" data-filter="*">Tất cả</li>
                    <li data-filter=".Nữ">Nữ</li>
                    <li data-filter=".Nam">Nam</li>
                    <li data-filter=".Trẻ em">Trẻ em</li>
                    <li data-filter=".Unisex">Unisex</li>
                    {{-- <li data-filter=".cosmetic">Mỹ phẩm</li> --}}
                </ul>
            </div>
        </div>
        <div class="row property__gallery">
            @foreach($newProductInfo as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 mix @foreach($product->categories as $category){{ $category->name }} @endforeach ">
                <div class="product__item">
                    <div class="product__item__pic set-bg" data-setbg="{{ asset($product->img) }}">
                        <div class="label new">Mới</div>
                        <ul class="product__hover">
                            <li><a href="{{ asset($product->img) }}" class="image-popup"><span class="arrow_expand"></span></a></li>
                            {{-- <li><a href="#"><span class="icon_heart_alt"></span></a></li> --}}
                            <li><a href="{{ route('client.shop.detail', $product->id) }}"><span class="icon_bag_alt"></span></a></li>
                        </ul>
                    </div>
                    <div class="product__item__text">
                        <h6><a href="{{ route('client.shop.detail', $product->id) }}">{{ $product->name }}</a></h6>
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
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Phần Sản Phẩm Kết Thúc -->

<!-- Phần Banner Bắt Đầu -->
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
                            <a href="{{ $banner->link }}">Mua ngay</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Phần Banner Kết Thúc -->

<!-- Phần Xu Hướng Bắt Đầu -->
<section class="trend spad">
    <div class="container">
        <div class="row">
            @php
                $count = 0;
                $sections = ['Xu Hướng Hot', 'Bán Chạy Nhất'];
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
                                <h4>{{ $sections[$count / 3] ?? 'Sản Phẩm Khác' }}</h4>
                            </div>
                @endif
                <div class="trend__item" style="cursor: pointer" onclick="window.location='{{ route('client.shop.detail', $product->id) }}'">
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
                        <h4>Ưa Thích</h4>
                    </div>
                    @foreach($favoriteProductInfo as $product)
                    <div class="trend__item"  style="cursor: pointer" onclick="window.location='{{ route('client.shop.detail', $product->id) }}'">
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
<!-- Phần Xu Hướng Kết Thúc -->

<!-- Phần Giảm Giá Bắt Đầu -->
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
                        <span>Giảm Giá</span>
                        <h2>{{ $latestPromotion->description }}</h2>
                        <h5><span>Giảm</span> {{ $latestPromotion->discount_percentage }}%</h5>
                    </div>
                    <div class="discount__countdown" id="countdown-time">
                        <div class="countdown__item">
                            <span id="days">{{ $latestPromotion->daysDiff }}</span>
                            <p>Ngày</p>
                        </div>
                        <div class="countdown__item">
                            <span id="hours">{{ $latestPromotion->hoursDiff }}</span>
                            <p>Giờ</p>
                        </div>
                        <div class="countdown__item">
                            <span id="minutes">{{ $latestPromotion->minsDiff }}</span>
                            <p>Phút</p>
                        </div>
                        <div class="countdown__item">
                            <span id="seconds">{{ $latestPromotion->secsDiff }}</span>
                            <p>Giây</p>
                        </div>
                    </div>
                    <a href="{{ route('client.shop.index') }}">Mua ngay</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Phần Giảm Giá Kết Thúc -->

<!-- Phần Dịch Vụ Bắt Đầu -->
<section class="services spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="services__item">
                    <i class="fa fa-car"></i>
                    <h6>Miễn Phí Vận Chuyển</h6>
                    <p>Cho tất cả đơn hàng trên $99</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="services__item">
                    <i class="fa fa-money"></i>
                    <h6>Bảo Đảm Hoàn Tiền</h6>
                    <p>Nếu hàng có vấn đề</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="services__item">
                    <i class="fa fa-support"></i>
                    <h6>Hỗ Trợ Trực Tuyến 24/7</h6>
                    <p>Hỗ trợ tận tâm</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="services__item">
                    <i class="fa fa-headphones"></i>
                    <h6>Thanh Toán An Toàn</h6>
                    <p>Thanh toán 100% an toàn</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Phần Dịch Vụ Kết Thúc -->
@endsection
