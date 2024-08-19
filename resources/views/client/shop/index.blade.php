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
                                    @foreach ($allCategories as $pCateg)
                                        @if ($loop->index == 4)
                                        @break
                                    @endif
                                    <div class="card">
                                        <div class="card-heading">
                                            <a data-toggle="collapse"
                                                data-target="#collapse-{{ $pCateg->id }}">{{ $pCateg->name }}</a>
                                        </div>
                                        <div id="collapse-{{ $pCateg->id }}" class="collapse"
                                            data-parent="#accordionExample">
                                            <div class="card-body">
                                                <ul id="categoryFilterItems">
                                                    @foreach ($allCategories as $cCateg)
                                                        @if ($loop->index < 4)
                                                            @continue
                                                        @endif
                                                        <li>
                                                            <label for="{{ $pCateg->id }}-{{ $cCateg->id }}">
                                                                <input type="checkbox"
                                                                    id="{{ $pCateg->id }}-{{ $cCateg->id }}"
                                                                    class="category-filter pointer"
                                                                    data-ParentCategory="{{ $pCateg->id }}"
                                                                    value="{{ $cCateg->id }}">
                                                                {{ $cCateg->name }}
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </li>
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
                                data-min="{{ $allProducts->min('price') }}"
                                data-max="{{ $allProducts->max('price') }}"></div>
                            <div class="range-slider">
                                <div class="price-input">
                                    <p>Price:</p>
                                    <input type="text" id="minamount">
                                    <input type="text" id="maxamount">
                                </div>
                            </div>
                            <a class="pointer" id="filter">Apply Filter</a>
                            <a class="pointer hidden" id="removeFilter">Reset</a>
                        </div>

                    </div>
                    <div class="sidebar__sizes">
                        <div class="section-title">
                            <h4>Shop by size</h4>
                        </div>
                        <div class="size__list">
                            @foreach ($allSizes as $size)
                                <label for="{{ $size->name }}">
                                    {{ $size->name }}
                                    <input type="checkbox" id="{{ $size->name }}" class="size-filter"
                                        value="{{ $size->id }}">
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
                            @foreach ($allColors as $index => $color)
                                <label for="{{ $color->name }}"
                                    class="color-item {{ $loop->index >= 5 ? 'hidden' : '' }}">
                                    {{ $color->name }}
                                    <input type="checkbox" id="{{ $color->name }}" class="color-filter"
                                        value="{{ $color->id }}">
                                    <span class="checkmark"></span>
                                </label>
                            @endforeach
                        </div>
                        @if (count($allColors) > 5)
                            <a id="see-more" class="pointer">More colors</a>
                        @endif
                    </div>

                </div>
            </div>
            <div class="col-lg-9 col-md-9">
                <div class="row" id="products-list">
                    @foreach ($allPageProducts as $product)
                        <div class="col-lg-4 col-md-6">
                            <div class=".product__item" style="cursor: pointer"
                                onclick="window.location='{{ route('client.shop.detail', $product->id) }}'">
                                <div class="product__item__pic set-bg" data-setbg="{{ $product->img }}">
                                    <div class="label new">New</div>
                                    <ul class="product__hover">
                                        <li><a href="img/shop/shop-1.jpg" class="image-popup"><span
                                                    class="arrow_expand"></span></a></li>
                                        {{-- <li><a href="#"><span class="icon_heart_alt"></span></a></li> --}}
                                        <li><a href="{{ route('client.shop.detail', $product->id) }}"><span
                                                    class="icon_bag_alt"></span></a></li>
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6><a
                                            href="{{ route('client.shop.detail', $product->id) }}">{{ $product->name }}</a>
                                    </h6>
                                    <div class="rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa=star"></i>
                                    </div>
                                    <div class="product__price">¥{{ $product->price }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{ $allPageProducts->links('client.shop.paginate') }}
                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="{{ asset('css/shop/shop.css') }}">
    </link>
    <script src="{{ url('') . '/' }}js/jquery-3.3.1.min.js"></script>
    <script src="{{ url('') . '/' }}js/shop/shop.js"></script>
</section>
<!-- Shop Section End -->
@endsection
