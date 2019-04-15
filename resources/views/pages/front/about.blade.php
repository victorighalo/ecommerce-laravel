@extends('layouts.newmain')

@section('content')

    <!--======= SUB BANNER =========-->
    @include('partials.frontend.sub_banner', ['title' => 'About us'])
    <!-- Content -->
    <div id="content">

        <!-- History -->
        <section class="history-block padding-top-100 padding-bottom-100">
            <div class="container">
                <div class="about-us-con">
                    {{$app_settings->store_about ? $app_settings->store_about : ""}}
                </div>
            </div>
        </section>



        {{--Product request--}}
        @include('partials.frontend.product_request')

    </div>

@endsection