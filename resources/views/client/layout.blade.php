<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Mẫu Ashion">
    <meta name="keywords" content="Ashion, unica, sáng tạo, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ashion | Mẫu</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cookie&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ url('') . '/' }}css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="{{ url('') . '/' }}css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="{{ url('') . '/' }}css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="{{ url('') . '/' }}css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="{{ url('') . '/' }}css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="{{ url('') . '/' }}css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="{{ url('') . '/' }}css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="{{ url('') . '/' }}css/style.css" type="text/css">
</head>

<body>
    <!-- Trình tải trang -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Bắt đầu Menu Offcanvas -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="offcanvas-menu-wrapper">
        <div class="offcanvas__close">+</div>
        <ul class="offcanvas__widget">
            <li><span class="icon_search search-switch"></span></li>
            <li><a href="#"><span class="icon_bag_alt"></span>
                    <div class="tip">2</div>
            <li class="nav-item dropdown" style="transform: translateY(-3px)">
                <a class="nav-link dropdown-toggle" href="#" id="heartDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle" width="21px"
                        src="{{ url('') . '/' }}img/user/{{ Auth::user() ? Auth::user()->avt : 'avt-default.png' }}"><img>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="heartDropdown" style="transform: translate(15px,-5px);">
                    @php
                        $user = Auth::user();
                    @endphp
                    @if (Auth::check())
                        <a class="dropdown-item" href="#routeToUserDetail#">Profile
                            {{ $user ? Str::lower($user->username) : '' }}</a>
                        <a class="dropdown-item" href="#">Points: {{ $user ? $user->point : '' }}P</a>
                        <a class="dropdown-item" href="{{ route('client.logout') }}">Logout</a>
                    @else
                        <a class="dropdown-item" href="{{ route('client.login.index') }}">Login</a>
                        <a class="dropdown-item" href="#registerRoute">Register</a>
                    @endif
                </div>
            </li>
            </a></li>
        </ul>
        <div class="offcanvas__logo">
            <a href="./index.html"><img src="{{ url('') . '/' }}img/logo.png" alt=""></a>
        </div>
        <div id="mobile-menu-wrap"></div>

        <div class="header__right__auth">
            @if (Auth::check())
                <ul>
                    <li><a href="#routeToUserDetail#"><b>{{ Str::upper(Auth::user()->username) }}</b></a>
                        <ul class="dropdown">
                            <li><a href="#">Points: {{ Auth::user()->point }}P</a></li>
                            <li><a href="#routeToUserDetail#">Profile</a></li>
                            <li><a href="{{ route('client.logout') }}">Logout</a></li>
                            {{-- <hr> --}}
                        </ul>
                    </li>
                </ul>
            @endif
            @if (!Auth::check())
                <a class="font-bold" href="{{ route('client.login.index') }}">Login</a> <br>
                <a class="font-bold" href="#registerRoute">Register</a>
            @endif
        </div>
    </div>
    <!-- Kết thúc Menu Offcanvas -->

    <!-- Bắt đầu Phần Header -->
    <header class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 col-lg-2">
                    <div class="header__logo">
                        <a href="{{ route('client.home.index') }}"><img src="{{ url('') . '/' }}img/logo.png" alt=""></a>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-7">
                    <nav class="header__menu">
                        <ul>

                            <li class="{{ Request::url() == route('client.home.index') || Request::url() == null ? 'active' : '' }}"><a href="{{ route('client.home.index') }}">Home</a></li>
                            <li><a href="{{ route('client.shop.index') }}">Female</a></li>
                            <li><a href="{{ route('client.shop.index') }}">Male</a></li>
                            <li><a href="{{ route('client.shop.index') }}">Kids</a></li>
                            <li class="{{ Request::url() == route('client.shop.index') ? 'active' : '' }}"><a href="{{ route('client.shop.index') }}">Shop</a></li>
                            <li><a href="{{ route('client.home.index') }}">Cart</a></li>
                            {{-- <li><a href="#">Page</a>
                                <ul class="dropdown">
                                    <li><a href="./product-details.html">Chi tiết sản phẩm</a></li>
                                    <li><a href="./shop-cart.html">Cart</a></li>
                                    <li><a href="./checkout.html">Thanh toán</a></li>
                                    <li><a href="./blog-details.html">Chi tiết Blog</a></li>
                                </ul>
                            </li> --}}
                            {{-- <li><a href="./blog.html">Blog</a></li> --}}
                            <li><a href="./contact.html">Contact</a></li>

                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3">
                    <div class="header__right">
                        <ul class="header__right__widget">
                            <li><span class="icon_search search-switch"></span></li>
                            <li><a href="#"><span class="icon_bag_alt"></span>

                                </a></li>
                            <li class="nav-item dropdown">
                                <a data-bs-toggle="none" class="nav-link dropdown-toggle" href="#"
                                    id="heartDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false" style="transform: translateY(-3px)">
                                    <img class="rounded-circle" width="23px"
                                        src="{{ url('') . '/' }}img/user/{{ Auth::user() ? Auth::user()->avt : 'avt-default.png' }}"><img>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="heartDropdown" style="transform: translate(15px,-8px);">
                                    @php
                                        $user = Auth::user();
                                    @endphp
                                    @if (Auth::check())
                                        <a class="dropdown-item" href="#routeToUserDetail#">Profile
                                            {{ $user ? Str::lower($user->username) : '' }}</a>
                                        <a class="dropdown-item" href="#">Points:
                                            {{ $user ? $user->point : '' }}P</a>
                                        <a class="dropdown-item" href="{{ route('client.logout') }}">Logout</a>
                                    @else
                                        <a class="dropdown-item" href="{{ route('client.login.index') }}">Login</a>
                                        <a class="dropdown-item" href="#registerRoute">Register</a>
                                    @endif
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
            <div class="canvas__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- Kết thúc Phần Header -->
    @yield('main')

    <!-- Bắt đầu Instagram -->
    <div class="instagram">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-2 col-md-4 col-sm-4 p-0">
                    <div class="instagram__item set-bg" data-setbg="{{ url('') . '/' }}img/product/product-1.jpg">
                        <div class="instagram__text">
                            <i class="fa fa-instagram"></i>
                            <a href="#">@ ashion_shop</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-4 p-0">
                    <div class="instagram__item set-bg" data-setbg="{{ url('') . '/' }}img/product/product-2.jpg">
                        <div class="instagram__text">
                            <i class="fa fa-instagram"></i>
                            <a href="#">@ ashion_shop</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-4 p-0">
                    <div class="instagram__item set-bg" data-setbg="{{ url('') . '/' }}img/product/product-3.jpg">
                        <div class="instagram__text">
                            <i class="fa fa-instagram"></i>
                            <a href="#">@ ashion_shop</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-4 p-0">
                    <div class="instagram__item set-bg" data-setbg="{{ url('') . '/' }}img/product/product-4.jpg">
                        <div class="instagram__text">
                            <i class="fa fa-instagram"></i>
                            <a href="#">@ ashion_shop</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-4 p-0">
                    <div class="instagram__item set-bg" data-setbg="{{ url('') . '/' }}img/product/product-5.jpg">
                        <div class="instagram__text">
                            <i class="fa fa-instagram"></i>
                            <a href="#">@ ashion_shop</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-4 p-0">
                    <div class="instagram__item set-bg" data-setbg="{{ url('') . '/' }}img/product/product-6.jpg">
                        <div class="instagram__text">
                            <i class="fa fa-instagram"></i>
                            <a href="#">@ ashion_shop</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Kết thúc Instagram -->

    <!-- Bắt đầu Phần Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-7">
                    <div class="footer__about">
                        <div class="footer__logo">
                            <a href="./index.html"><img src="{{ url('') . '/' }}img/logo.png" alt=""></a>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                            cilisis.</p>
                        <div class="footer__payment">
                            <a href="#"><img src="{{ url('') . '/' }}img/payment/payment-1.png"
                                    alt=""></a>
                            <a href="#"><img src="{{ url('') . '/' }}img/payment/payment-2.png"
                                    alt=""></a>
                            <a href="#"><img src="{{ url('') . '/' }}img/payment/payment-3.png"
                                    alt=""></a>
                            <a href="#"><img src="{{ url('') . '/' }}img/payment/payment-4.png"
                                    alt=""></a>
                            <a href="#"><img src="{{ url('') . '/' }}img/payment/payment-5.png"
                                    alt=""></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-5">
                    <div class="footer__widget">
                        <h6>Liên kết nhanh</h6>
                        <ul>
                            <li><a href="#">Giới thiệu</a></li>
                            <li><a href="#">Blog</a></li>
                            <li><a href="#">Liên hệ</a></li>
                            <li><a href="#">FAQ</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4">
                    <div class="footer__widget">
                        <h6>Tài khoản</h6>
                        <ul>
                            <li><a href="#">Tài khoản của tôi</a></li>
                            <li><a href="#">Theo dõi đơn hàng</a></li>
                            <li><a href="#">Thanh toán</a></li>
                            <li><a href="#">Danh sách yêu thích</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-8 col-sm-8">
                    <div class="footer__newslatter">
                        <h6>BẢN TIN</h6>
                        <form action="#">
                            <input type="text" placeholder="Email">
                            <button type="submit" class="site-btn">Đăng ký</button>
                        </form>
                        <div class="footer__social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-youtube-play"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                            <a href="#"><i class="fa fa-pinterest"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <!-- Liên kết đến Colorlib không thể bị xóa. Mẫu được cấp phép theo CC BY 3.0. -->
                    <div class="footer__copyright__text">
                        <p>Bản quyền &copy;
                            <script>
                                document.write(new Date().getFullYear());
                            </script> Tất cả các quyền được bảo lưu | Mẫu này được làm với <i
                                class="fa fa-heart" aria-hidden="true"></i> bởi <a href="https://colorlib.com"
                                target="_blank">Colorlib</a>
                        </p>
                    </div>
                    <!-- Liên kết đến Colorlib không thể bị xóa. Mẫu được cấp phép theo CC BY 3.0. -->
                </div>
            </div>
        </div>
    </footer>
    <!-- Kết thúc Phần Footer -->

    <!-- Bắt đầu Tìm kiếm -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch">+</div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="  Search here....">
            </form>
        </div>
    </div>
    <!-- Kết thúc Tìm kiếm -->

    <!-- Js Plugins -->
    <script src="{{ url('') . '/' }}js/jquery-3.3.1.min.js"></script>
    <script src="{{ url('') . '/' }}js/bootstrap.min.js"></script>
    <script src="{{ url('') . '/' }}js/jquery.magnific-popup.min.js"></script>
    <script src="{{ url('') . '/' }}js/jquery-ui.min.js"></script>
    <script src="{{ url('') . '/' }}js/mixitup.min.js"></script>
    <script src="{{ url('') . '/' }}js/jquery.countdown.min.js"></script>
    <script src="{{ url('') . '/' }}js/jquery.slicknav.js"></script>
    <script src="{{ url('') . '/' }}js/owl.carousel.min.js"></script>
    <script src="{{ url('') . '/' }}js/jquery.nicescroll.min.js"></script>
    <script src="{{ url('') . '/' }}js/main.js"></script>
    <script src="{{ url('') . '/' }}js/popper.min.js"></script>
</body>

</html>
