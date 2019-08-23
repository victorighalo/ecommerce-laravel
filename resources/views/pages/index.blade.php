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
    <script>
        $(document).ready(function(){
            $(".owl-carousel").owlCarousel({
                // loop:true,
                nav:false,
                autoHeight: true,
                autoplay: true,
                responsive:{
                    0:{
                        items:1
                    },
                    600:{
                        items:1
                    },
                    1000:{
                        items:1
                    }
                }
            });
        });
    </script>
    @endpush
