@extends('layouts.newmain')

@section('content')
    @include('partials.frontend.slider_home')
    <div id="content">
        <!-- Shop By Category -->
        @include('partials.frontend._search')
        @include('partials.frontend.home._categories')
        <!-- Products by Category -->
        @include('partials.frontend.home._products_by_category')
        <!-- Popular Products -->
        @include('partials.frontend.home._newproducts')
        {{--Product request--}}
        @include('partials.frontend.product_request')
    </div>
    @endsection
@push('script')
    <script src="{{ asset('assets/js/slick.min.js')}}"></script>

    <script>
        $(document).ready(function(){
            $('.slick').slick({
                autoplay: true,
                autoplaySpeed: 5000,
                arrows:false,
                // fade:true
            });
        });
    </script>
    @endpush
