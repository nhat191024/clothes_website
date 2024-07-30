@extends('client.layout')
@section('main')
 <!-- Shop Section Begin -->
 
 <section class="shop spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3">
                <div class="shop__sidebar">
                    <div class="sidebar__categories">
                        <div class="section-title">
                            <h4>Categories</h4>
                        </div>
                        <div class="categories__accordion">
                            <div class="accordion" id="accordionExample">
                                @foreach($parentCategory as $pCateg)
                                <div class="card">
                                    <div class="card-heading active">
                                        <a data-toggle="collapse" data-target="#collapseOne">{{ $pCateg->name }}</a>
                                    </div>
                                    <div id="collapseOne" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body" >
                                            <ul >
                                                @foreach($childCategory as $cCateg)
                                                <li><a href="#" data-ParentCategory="{{ $pCateg->id }}" data-ChildCategory="{{ $cCateg->id }}" >{{ $cCateg->name }}</a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="sidebar__filter">
                        <div class="section-title">
                            <h4>Shop by price</h4>
                        </div>
                        <div class="filter-range-wrap">
                            <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                            data-min="{{$minPrice}}" data-max="{{$maxPrice}}"></div>
                            <div class="range-slider">
                                <div class="price-input">
                                    <p>Price:</p>
                                    <input type="text" id="minamount">
                                    <input type="text" id="maxamount">
                                </div>
                            </div>
                        </div>
                        <a href="#">Filter</a>
                    </div>
                    <div class="sidebar__sizes">
                        <div class="section-title">
                            <h4>Shop by size</h4>
                        </div>
                        <div class="size__list">
                            @foreach($sizes as $size)
                            <label for="{{ $size->name }}">
                                {{ $size->name }}
                                <input type="checkbox" id="{{ $size->name }}" class="size-filter" value="{{ $size->id }}">
                                <span class="checkmark"></span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="sidebar__color">
                        <div class="section-title">
                            <h4>Shop by color</h4>
                        </div>
                        <div class="size__list color__list">
                            @foreach($colors as $color)
                            <label for="{{ $color->name }}">
                                {{ $color->name }}
                                <input type="checkbox" id="{{ $color->name }}" class="color-filter" value="{{ $color->id }}">
                                <span class="checkmark"></span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-9">
                <div class="row" id="productA-list">
                    @foreach($allProducts as $product)
                    <div class="col-lg-4 col-md-6">
                        <div class=".product__item">
                            <div class="product__item__pic set-bg" data-setbg="{{ $product->img }}">
                                <div class="label new">New</div>
                                <ul class="product__hover">
                                    <li><a href="img/shop/shop-1.jpg" class="image-popup"><span class="arrow_expand"></span></a></li>
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
                                    <i class="fa fa=star"></i>
                                </div>
                                <div class="product__price">{{ $product->price }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    {{ $allProducts->links('client.shop.paginate') }}
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Shop Section End -->
@endsection