@extends('client.layout')
@section('main')
    <div class="hero-wrap hero-bread" style="background-image: url({{ URL::asset('img/home/bg-1.webp') }});">
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-9 ftco-animate text-center">
                    <p class="breadcrumbs"><span class="mr-2"><a
                                href=""></a></span>/<span></span>
                    </p>
                    <h1 class="mb-0 bread"></h1>
                </div>
            </div>
        </div>
    </div>

    <section class="ftco-section ftco-no-pb ftco-no-pt bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-5 p-md-5 img img-2 d-flex justify-content-center align-items-center"
                    style="background-image: url('{{ URL::asset('img/about/'. ($About_us->image ?? 'logo.png')) }}');">
                    <a href="#"
                        class="icon popup-vimeo d-flex justify-content-center align-items-center">
                        <span class="icon-play"></span>
                    </a>
                </div>
                <div class="col-md-7 py-5 wrap-about pb-md-5 ftco-animate">
                    <div class="heading-section-bold mb-4 mt-md-5">
                        <div class="ml-md-0">
                            <h2 class="mb-4">
                               {{ $About_us->title }}
                            </h2>
                        </div>
                    </div>
                    <div class="pb-md-5">
                        <p>
                       {{ $About_us->description }}
                        </p>
                        <p><a href="{{route('client.shop.index')}}"
                                class="btn-acconut">Shop Now</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
