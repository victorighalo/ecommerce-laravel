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

        <!-- Culture BLOCK -->
        <section class="cultur-block">
            <ul>
                <li> <img src="images/cultur-img-1.jpg" alt="" > </li>
                <li> <img src="images/cultur-img-2.jpg" alt="" > </li>
                <li> <img src="images/cultur-img-3.jpg" alt="" > </li>
                <li> <img src="images/cultur-img-4.jpg" alt="" > </li>
            </ul>

            <!-- Culture Text -->
            <div class="position-center-center">
                <div class="container">
                    <div class="col-sm-6 center-block">
                        <h4>Awesome Work Culture</h4>
                        <p>Phasellus lacinia fermentutm bibendum. Interdum et malante ipuctus non. Nulla lacinia,
                            eros vel fermentum consectetur, ris dolor in ex. </p>
                    </div>
                </div>
            </div>
        </section>

        {{--Product request--}}
        @include('partials.frontend.product_request')

    </div>

@endsection