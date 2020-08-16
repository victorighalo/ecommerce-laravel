<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="WyzWeb">
{{--    <title>{{ config('app.name', '') }}</title>--}}
    {!! SEOMeta::generate(true) !!}

    <meta name="csrf-token" content="{{ csrf_token() }}">


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
    <link href="{{asset('assets/css/slick.css')}}" rel="stylesheet">

    <link href="{{asset('assets/font/flaticon.css')}}" rel="stylesheet">
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <link href="{{asset('css/main.css')}}" rel="stylesheet">
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


    @stack('style')

</head>
<body>
<div id="wrap">
   @include('partials.frontend.header')
    @yield('content')
    @include('partials.frontend.categories_slider')
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
    $("form[name='product_request']").on('submit', function (e) {
        e.preventDefault();
        var objectRef = $(this);
        // $(this).find('button').attr('disabled', true);
        // $(this).find('input').attr('disabled', true);
        $(this).find('button').text('Sending...');
        $.ajax({
            url:"{!! route('send_product_request') !!}",
            data:$(this).serializeArray(),
            method:'POST'
        })
            .done(function (res) {
                objectRef.find('button').attr('disabled', false);
                objectRef.find('input').attr('disabled', false);
                objectRef.find('textarea').attr('disabled', false);
                objectRef.find('button').text('Send');
                Snackbar.show({
                    showAction: true,
                    text: 'Message sent. We will get in touch ASAP.',
                    actionTextColor: '#ffffff',
                    backgroundColor:"#68d391",
                    actionText: 'Close!',
                    pos: 'top-right'
                });
            })
            .fail(function (err) {
                objectRef.find('button').attr('disabled', false);
                objectRef.find('input').attr('disabled', false);
                objectRef.find('textarea').attr('disabled', false);
                objectRef.find('button').text('Send');
                Snackbar.show({
                    showAction: true,
                    text: 'Error sending message. Try again.',
                    actionTextColor: '#ffffff',
                    backgroundColor:"#FE970D",
                    actionText: 'Close!',
                    pos: 'top-right'
                });
            })
    })
</script>
@stack('script')
</html>
