@extends('client.layout')
@section('main')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="./index.html"><i class="fa fa-home"></i> Home</a>
                        <span>Shopping cart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h6 class="coupon__link">
                        <span class="icon_tag_alt"></span>
                        <a href="{{ route('client.cart.index') }}">Have a coupon? Click here to enter your code.</a>
                    </h6>
                </div>
            </div>
            <form action="#" class="checkout__form">
                <div class="row">
                    <div class="col-lg-8 mb-4">
                        <h5>Billing detail</h5>
                        <div class="row">
                            <div class="col-lg-12 col-md-6 col-sm-6">
                                <div class="checkout__form__input">
                                    <p>Full name<span>*</span></p>
                                    <input type="text" id="fullName" required placeholder="Your full name"
                                        @if ($user) value="{{ $user->full_name }}" @endif />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                {{-- <div class="checkout__form__input">
                                    <p>都道府県 (Prefecture)<span>*</span></p>
                                    <select id="prefecture" name="prefecture" class="form-control" required>
                                        <option value="" disabled selected>Select Prefecture</option>
                                        <option value="Tokyo">Tokyo</option>
                                        <option value="Osaka">Osaka</option>
                                        <option value="Kyoto">Kyoto</option>
                                        <!-- Add other prefectures as needed -->
                                    </select>
                                </div> --}}

                                <div class="checkout__form__input">
                                    <p>Prefecture<span>*</span></p>
                                    <input type="text" id="prefecture" name="Prefecture" required
                                        placeholder="Your Prefecture" />
                                </div>
                                <div class="checkout__form__input">
                                    <p>City/Town/Village<span>*</span></p>
                                    <input type="text" id="city" name="city" required
                                        placeholder="Your city/town/village" />
                                </div>
                                <div class="checkout__form__input">
                                    <p>Street Address<span>*</span></p>
                                    <input type="text" placeholder="Your street Address" id="address" required />
                                </div>
                                <div class="checkout__form__input">
                                    <p>Building Name & Room Number</p>
                                    <input type="text" id="buildingName" name="buildingName"
                                        placeholder="Shibuya Heights 101" />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="checkout__form__input">
                                    <p>Phone Number<span>*</span></p>
                                    <input type="text" id="phoneNumber" name="phoneNumber" required
                                        placeholder="090-1234-5678"
                                        @if ($user) value="{{ $user->phone }}" @endif />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="checkout__form__input">
                                    <p>Email<span>*</span></p>
                                    <input type="email" id="email" name="email" required
                                        placeholder="Your email address"
                                        @if ($user) value="{{ $user->email }}" @endif />
                                </div>
                            </div>
                            <div class="col-lg-12">
                                {{-- <div class="checkout__form__checkbox">
                                    <label for="acc">
                                        Create an acount?
                                        <input type="checkbox" id="acc" />
                                        <span class="checkmark"></span>
                                    </label>
                                    <p>
                                        Create am acount by entering the
                                        information below. If you are a
                                        returing customer login at the
                                        <br />top of the page
                                    </p>
                                </div>
                                <div class="checkout__form__input">
                                    <p>Account Password <span>*</span></p>
                                    <input type="text" />
                                </div> --}}
                                <div class="checkout__form__input">
                                    <p></p>Delivery method<span>*</span></p>
                                    <select id="delivery" name="delivery" class="form-control" required>
                                        <option value="" disabled selected>Select Delivery</option>
                                        <option value="0">Pick up at the store</option>
                                        <option value="1">Economical delivery</option>
                                        <option value="2">Express delivery</option>
                                    </select>
                                    <!-- Add other prefectures as needed -->
                                    </select>
                                </div>

                                <div class="checkout__form__input mt-4">
                                    <p>Payment method<span>*</span></p>
                                    <select id="payment" name="payment" class="form-control" required>
                                        <option value="" disabled selected>
                                            Select delivery method to show other payment method
                                        </option>
                                    </select>
                                </div>
                                {{-- <div class="checkout__form__input mt-4">
                                    <p>Oder notes</p>
                                    <input type="text" id="note" name="note"
                                        placeholder="Note about your order, e.g, special noe for delivery" />
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 ">
                        <div class="checkout__order">
                            <h5>Your order</h5>
                            <div class="checkout__order__product">
                                <ul>
                                    <li>
                                        <span class="top__text">Product</span>
                                        <span class="top__text__right">Unit price</span>
                                    </li>
                                    @foreach ($carts as $key => $item)
                                        <li class="d-flex justify-content-between">
                                            <div class="d-flex flex-column">
                                                <span class=" w-75">
                                                    x{{ $item['quantity'] }}
                                                    {{ $item['productDetail']->product->name }}
                                                </span>
                                                size: {{ $item['productDetail']->size->name }}-
                                                {{ $item['productDetail']->color->name }}
                                            </div>
                                            <span>¥{{ number_format($item['price']) }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="checkout__order__total">
                                <ul>
                                    <li>Subtotal <span>¥{{ number_format($subTotal) }}</span></li>
                                    <li>Voucher discount <span>¥{{ number_format($discount) }}</span></li>
                                    <li>Point discount<span id="pointDiscount">¥0</span></li>
                                    <li>Total <span id="total">¥{{ number_format($total) }}</span></li>
                                </ul>
                            </div>
                            <div class="checkout__order__widget">
                                {{-- <label for="o-acc">
                                    Create an acount?
                                    <input type="checkbox" id="o-acc" />
                                    <span class="checkmark"></span>
                                </label>
                                <p>
                                    Create am acount by entering the
                                    information below. If you are a returing
                                    customer login at the top of the page.
                                </p>
                                <label for="check-payment">
                                    Cheque payment
                                    <input type="checkbox" id="check-payment" />
                                    <span class="checkmark"></span>
                                </label> --}}
                                {{-- <label for="paypal">
                                    PayPal
                                    <input type="checkbox" id="paypal" />
                                    <span class="checkmark"></span>
                                </label> --}}
                                @if ($user)
                                    <label for="point">
                                        <span>Pay using point ({{ $user->point }})</span>
                                        <input type="checkbox" id="point"
                                            @if ($user->point == 0) disabled @endif />
                                        <span class="checkmark"></span>
                                    </label>
                                @endif
                                <label for="confirm">
                                    All information above is correct
                                    <input type="checkbox" id="confirm" required />
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <button type="submit" class="site-btn">
                                Place oder
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- Checkout Section End -->

    <div class="modal" id="myModal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header  d-flex justify-content-center">
                    <h4 class="modal-title">QR payment for orders</h4>
                </div>
                <div class="modal-body d-flex justify-content-center align-items-center flex-column">
                    {{-- <img id="modalImage" src="" alt="QR"> --}}
                    <p>this is just a demo</p>
                    {{-- <hr>
                    <div class="d-flex justify-content-center h5">
                        <span class="mx-1">STK: <strong>113366668888</strong></span>
                        <span class="mx-1">Chủ tài khoản: <strong>TRINH THU DUNG</strong></span>
                    </div>
                    <p class="h5">Ngân hàng thụ hưởng: <strong>ViettinBank</strong></p>
                    <span class="mx-1 h5">Tổng tiền: <strong id="total"></strong></span>
                    <span class="mx-1 h5">Nội dung: <strong id="description"></strong></span> --}}
                </div>
                <div class="modal-footer" onclick="home()">
                    <button class="btn btn-success" data-dismiss="modal">
                        Back to homepage
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="checkout-preloader">
        <div class="checkout-loader"></div>
        <p class="checkout-text">Please wait while we are processing your order</p>
    </div>

    <script>
        const total = {{ $total }};
        @if ($user)
            const point = {{ $user->point }};
        @endif
    </script>

    <script src="{{ url('') . '/' }}js/jquery-3.3.1.min.js"></script>
    <script src="{{ asset('js/checkout/checkout.js') }}"></script>

    <style>
        #checkout-preloader {
            visibility: hidden;
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 10;
            background-color: rgba(0, 0, 0, 0.5);
            cursor: 'pointer'
        }

        .checkout-loader {
            width: 40px;
            height: 40px;
            position: absolute;
            top: 50%;
            left: 50%;
            margin-top: -13px;
            margin-left: -13px;
            border-radius: 60px;
            animation: loader 0.8s linear infinite;
            -webkit-animation: loader 0.8s linear infinite;
        }

        .checkout-text {
            color: black;
            width: 100%;
            height: 20px;
            position: absolute;
            text-align: center;
            top: 55%;
            z-index: 20;
        }

        @keyframes checkout-loader {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
                border: 4px solid #f44336;
                border-left-color: transparent;
            }

            50% {
                -webkit-transform: rotate(180deg);
                transform: rotate(180deg);
                border: 4px solid #673ab7;
                border-left-color: transparent;
            }

            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
                border: 4px solid #f44336;
                border-left-color: transparent;
            }
        }

        @-webkit-keyframes checkout-loader {
            0% {
                -webkit-transform: rotate(0deg);
                border: 4px solid #f44336;
                border-left-color: transparent;
            }

            50% {
                -webkit-transform: rotate(180deg);
                border: 4px solid #673ab7;
                border-left-color: transparent;
            }

            100% {
                -webkit-transform: rotate(360deg);
                border: 4px solid #f44336;
                border-left-color: transparent;
            }
        }
    </style>
@endsection
