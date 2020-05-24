<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>
{{--    {!! SEOMeta::generate(true) !!}--}}
    <!-- Styles -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

    <link href="{{ asset('admin/css/main/app.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/bootstrap-tagsinput.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/custom.css') }}" rel="stylesheet">
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
{{--    <link href="{{ asset('admin/css/uikit.css') }}" rel="stylesheet">--}}
    @stack('style')
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
<script src="{{ asset('admin/js/admin.js') }}" ></script>
<script src="{{ asset('admin/js/all.js') }}" ></script>
<script src="{{ asset('admin/js/quill.min.js') }}" ></script>
<script src="{{ asset('plugins/jquery.blockUI.js') }}" ></script>
<script src="{{ asset('admin/js/uikit.js') }}" ></script>
<script src="{{ asset('admin/js/uikit-icons.js') }}" ></script>
<script>
    $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI)

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var s3Url = " https://s3.{{env('AWS_DEFAULT_REGION') }}.amazonaws.com/{{env('AWS_BUCKET')}}/images/thumbnail/";
    var uploadUrl = "{{route('media_upload')}}";
    var photoDriver = "{{config('app.PHOTO_DRIVER')}}";


    $(document).ready(function () {
        $(".loader_container").hide();
    })
</script>

@stack('script')
</html>
