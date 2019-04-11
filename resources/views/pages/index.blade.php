@extends('layouts.newmain')

@section('content')
    @include('partials.frontend.slider_home')
    <div id="content">
        <!-- Shop By Category -->
        @include('partials.frontend.home._categories')
        <!-- Intro Section -->
        <section class="light-gray-bg padding-top-100 padding-bottom-100">
            <div class="container">
                <div class="intro-sec">
                    <div class="center-block">
                        <h3>We are building high quality products from the latest fashion. we are providing fully customization cloth for Mens, Women and Kids . we have full verity of <br>
                            <small><span> <b>01</b>: Shirts </span><span><b>02</b>: T-shirt </span><span><b>03</b>: Jean </span><span><b>04</b>: Uppers </span><span><b>05</b>: Hoodies </span><span><b>06</b>: Polo Shirts </span><span><b>07</b>: Caps  & Many More </span></small></h3>
                        <a href="#." class="btn btn-inverse margin-right-20">For Customization</a> <a href="#." class="btn">Order Now </a> </div>
                </div>
            </div>
        </section>
        <!-- Products by Category -->
        @include('partials.frontend.home._products_by_category')
        <!-- Popular Products -->
        @include('partials.frontend.home._newproducts')
        {{--Product request--}}
        @include('partials.frontend.product_request')
    </div>
    @endsection