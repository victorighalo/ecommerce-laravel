<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="apple-touch-icon.png" rel="apple-touch-icon">
    <link href="favicon.png" rel="icon">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    {{--<script src="{{ asset('js/app.js') }}" defer></script>--}}

    <!-- Fonts -->
    <link rel="stylesheet" href="{{asset('plugins/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/furniture-icon/style.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/bootstrap/dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/owl-carousel/assets/owl.carousel.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/bootstrap-select/dist/css/bootstrap-select.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/jquery-bar-rating/dist/themes/fontawesome-stars.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/slick/slick/slick.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/jquery-ui/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/lightGallery-master/dist/css/lightgallery.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/snackbar.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <style>

        .off {
            display: none;
        }
        .on {
            display: block;
        }    </style>
</head>
{{--<!--[if IE 7]><body class="ie7 lt-ie8 lt-ie9 lt-ie10"><![endif]-->--}}
{{--<!--[if IE 8]><body class="ie8 lt-ie9 lt-ie10"><![endif]-->--}}
{{--<!--[if IE 9]><body class="ie9 lt-ie10"><![endif]-->--}}
<body>
<div id="app">
    <div class="header--sidebar"></div>
    @include('partials.header')
    @yield('content')
    @include('partials.footer')
</div>
<script src="{{ asset('plugins/jquery.min.js')}}"></script>
<script src="{{ asset('plugins/lightGallery-master/dist/js/lightgallery-all.min.js')}}"></script>
<script src="{{ asset('plugins/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('plugins/owl-carousel/owl.carousel.min.js')}}"></script>
<script src="{{ asset('plugins/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
<script src="{{ asset('plugins/jquery-bar-rating/dist/jquery.barrating.min.js')}}"></script>
<script src="{{ asset('plugins/imagesloaded.pkgd.js')}}"></script>
<script src="{{ asset('plugins/masonry.pkgd.min.js')}}"></script>
<script src="{{ asset('plugins/isotope.pkgd.min.js')}}"></script>
<script src="{{ asset('plugins/slick/slick/slick.min.js')}}"></script>
<script src="{{ asset('plugins/jquery.matchHeight-min.js')}}"></script>
<script src="{{ asset('plugins/elevatezoom/jquery.elevatezoom.js')}}"></script>
<script src="{{ asset('plugins/gmap3.min.js')}}"></script>
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<script src="{{ asset('plugins/snackbar.min.js')}}"></script>

<!-- Custom scripts-->
<script src="{{ asset('js/main.js')}}"></script>
{{--<script src="{{ asset('js/app.js') }}"></script>--}}
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@stack('script')
</body>
</html>
