<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="WyzWeb">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', '') }}</title>

    <!-- SLIDER REVOLUTION 4.x CSS SETTINGS -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/rs-plugin/css/settings.css')}}" media="screen" />

    <!-- Bootstrap Core CSS -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{asset('assets/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/ionicons.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('plugins/jquery-bar-rating/dist/themes/fontawesome-stars.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/snackbar.min.css')}}">
    <link href="{{asset('assets/css/main.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/responsive.css')}}" rel="stylesheet">
    <link href="{{asset('assets/font/flaticon.css')}}" rel="stylesheet">


    <!-- JavaScripts -->
    <script src="{{ asset('assets/js/modernizr.js')}}"></script>

    <!-- Online Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Merriweather:300,400,700,900|Poppins:300,400,500,600,700|Montserrat:300,400,500,600,700,800" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>

        .off {
            display: none;
        }
        .on {
            display: block;
        }

        /* alerts */

        .alert {
            border: 0;
            border-radius: 0;
            padding: 20px 15px !important;
            line-height: 20px;
            font-weight: 300;
            color: #fff;
        }

        .alert .alert-icon {
            display: block;
            float: left;
            margin-right: 1.071rem;
        }

        .alert b {
            font-weight: 500;
            font-size: 12px;
            text-transform: uppercase;
        }

        .close {
            float: right;
            font-size: 1.5rem;
            color: #000;
            text-shadow: 0 1px 0 #fff;
            opacity: .5;
        }
        .alert .close {
            color: #fff;
            text-shadow: none;
            opacity: .9;
        }
        .alert .close i {
            font-size: 20px;
        }
        .alert .close:hover{
            opacity: 1;
            color: #fff;
        }
        .alert.alert-info {
            background-color: #00cae3;
            color: #fff;
        }

        .alert.alert-success {
            background-color: #55b559;
            color: #fff;
        }

        .alert.alert-warning {
            background-color: #ff9e0f;
            color: #fff;
        }

        .alert.alert-danger {
            background-color: #f55145;
            color: #fff;
        }

        .alert.alert-primary {
            background-color: #a72abd;
            color: #fff;
        }
        .arrival-block .tab-content{
            width: 100%;
        }

    </style>


</head>
<body>
<div id="wrap">
   @include('partials.frontend.header')
    @yield('content')
   @include('partials.frontend.footer')
</div>

</body>
<script src="{{ asset('assets/js/jquery-1.12.4.min.js')}}"></script>
<script src="{{ asset('assets/js/popper.min.js')}}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('assets/js/own-menu.js')}}"></script>
<script src="{{ asset('assets/js/jquery.lighter.js')}}"></script>
<script src="{{ asset('assets/js/jquery.magnific-popup.min.js')}}"></script>
<script src="{{ asset('assets/js/owl.carousel.min.js')}}"></script>
<script src="{{ asset('assets/js/lazysizes.min.js')}}"></script>
<script src="{{ asset('assets/js/main.js')}}"></script>
<script src="{{ asset('plugins/snackbar.min.js')}}"></script>
<script src="{{ asset('plugins/jquery-bar-rating/dist/jquery.barrating.min.js')}}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@stack('script')
</html>