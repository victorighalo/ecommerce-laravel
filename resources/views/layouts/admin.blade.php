<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>
    <!-- Styles -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

    <link href="{{ asset('admin/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/bootstrap-tagsinput.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/quill.bubble.css') }}" rel="stylesheet">
    <style>
        .bootstrap-tagsinput{
            width: 100%;
        }
        .bootstrap-tagsinput .tag {
            color: black;
            background: silver;
            padding: 3px;
        }
        .product_img_container{
            display: inline-block;
            position: relative;
        }
        .product_img_container:hover .product_img_container_delete{
            display: block;
            width: 100%;
            height: 100%;
            top: 0;
            left:0;
            background: rgba(000,000,000,0.7);
            cursor: pointer;
        }
        .product_img_container_delete{
            position: absolute;
            padding: 10px;
        }
        .brighttheme .ui-pnotify-action-button{
            color: #fff;
        }
    </style>
</head>
<body>
<div id="app">
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
    @include('partials.topnav')
    <!-- partial -->
        <div class="page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            @include('partials.sidebar')

            @yield('content')
        </div>
    </div>
    @include('partials.footer_admin')
</div>
</body>
<!-- Scripts -->
<script src="{{ asset('admin/js/manifest.js') }}"></script>
<script src="{{ asset('admin/js/vendor.js') }}"></script>
<script src="{{ asset('admin/js/app.js') }}" ></script>
<script src="{{ asset('admin/js/all.js') }}" ></script>
<script src="{{ asset('admin/js/quill.min.js') }}" ></script>
<script src="{{ asset('plugins/jquery.blockUI.js') }}" ></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var s3Url = " https://s3.{{env('AWS_DEFAULT_REGION') }}.amazonaws.com/{{env('AWS_BUCKET')}}/images/thumbnail/";
    var uploadUrl = "{{route('media_upload')}}";
    var photoDriver = "{{config('app.PHOTO_DRIVER')}}";
</script>
@stack('script')
</html>
