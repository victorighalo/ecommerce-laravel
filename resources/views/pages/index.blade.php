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
        <!-- About -->
        <section class="small-about">
            <div class="container-full">
                <div class="news-letter padding-top-150 padding-bottom-150">
                    <div class="row">
                        <div class="col-lg-6">
                            <h3>We always stay with our clients and respect their business. We deliver 100% and provide instant response to help them succeed in constantly changing and challenging business world. </h3>
                            <ul class="social_icons">
                                <li><a href="#."><i class="icon-social-facebook"></i></a></li>
                                <li><a href="#."><i class="icon-social-twitter"></i></a></li>
                                <li><a href="#."><i class="icon-social-tumblr"></i></a></li>
                                <li><a href="#."><i class="icon-social-youtube"></i></a></li>
                                <li><a href="#."><i class="icon-social-dribbble"></i></a></li>
                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <h3>Subscribe Our Newsletter</h3>
                            <span>Phasellus lacinia fermentum bibendum. Interdum et malesuada fames ac.</span>
                            <form>
                                <input type="email" placeholder="Enter your email address" required>
                                <button type="submit">Subscribe</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Knowledge Share -->
        <section class="light-gray-bg padding-top-100 padding-bottom-100">
            <div class="container-full">

                <!-- Main Heading -->
                <div class="heading text-center">
                    <h4>Knowledge Share</h4>
                    <hr>
                </div>
                <div class="knowledge-share">
                    <ul class="row">
                        <!-- Post 1 -->
                        <li class="col">

                            <!-- Post Img -->
                            <div class="img-por"> <img src="images/history-img.jpg" alt=""></div>
                            <article>
                                <!-- Date And comment -->
                                <div class="date"> <span class="huge">10</span> <span>January</span></div>
                                <div class="com-sec"> <span>By: <strong><a href="#.">Admin</a></strong></span> <span>Comments: <strong><a href="#.">32</a></strong></span> </div>
                                <div class="clearfix"></div>
                                <a href="#." class="b-tittle">Donec commo is vulputate</a>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec faucibus maximus vehicula. tellus vel tristique posuere, <a href="#.">Read more</a></p>
                            </article>
                        </li>

                        <!-- Post 2 -->
                        <li class="col">

                            <!-- Post Img -->
                            <div class="img-por"> <img src="images/about-img.jpg" alt=""></div>
                            <article>
                                <!-- Date And comment -->
                                <div class="date"> <span class="huge">25</span> <span>February</span></div>
                                <div class="com-sec"> <span>By: <strong><a href="#.">Admin</a></strong></span> <span>Comments: <strong><a href="#.">32</a></strong></span> </div>
                                <div class="clearfix"></div>
                                <a href="#." class="b-tittle">Donec commo is vulputate</a>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec faucibus maximus. Sed feugiat, tellus vel tristique posuere, <a href="#.">Read more</a></p>
                            </article>
                        </li>

                        <!-- Post 2 -->
                        <li class="col">
                            <!-- Post Img -->
                            <div class="img-por"> <img src="images/custom-img.jpg" alt=""></div>
                            <article>
                                <!-- Date And comment -->
                                <div class="date"> <span class="huge">25</span> <span>February</span></div>
                                <div class="com-sec"> <span>By: <strong><a href="#.">Admin</a></strong></span> <span>Comments: <strong><a href="#.">32</a></strong></span> </div>
                                <div class="clearfix"></div>
                                <a href="#." class="b-tittle">Donec commo is vulputate</a>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec faucibus maximus vehicula. Sed feugiat, tellus vel tristique posuere, <a href="#.">Read more</a></p>
                            </article>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Testimonial -->
        <section class="testimonial padding-top-60 padding-bottom-80">
            <div class="container"> <i class="fa fa-quote-left"></i>

                <!-- Slide -->
                <div class="single-slide">

                    <!-- Slide -->
                    <div class="testi-in">
                        <p>Phasellus lacinia fermentum bibendum. Interdum et malesuada fames ac ante ipsum primis in faucibus. Sed ullamcorper sapien lacus, eu luctus non. Nulla lacinia, eros vel fermentum consectetur,</p>
                        <h5>John Smith</h5>
                        <span>Themeforest</span> </div>

                    <!-- Slide -->
                    <div class="testi-in">
                        <p>Phasellus lacinia fermentum bibendum. Interdum et malesuada fames ac ante ipsum primis in faucibus. Sed lacus, eu posuere odio luctus non. Nulla lacinia, eros vel fermentum consectetur, </p>
                        <h5>John Smith</h5>
                        <span>Themeforest</span> </div>

                    <!-- Slide -->
                    <div class="testi-in">
                        <p>Phasellus lacinia fermentum bibendum. Interdum et malesuada fames ac ante ipsum. Sed ullamcorper sapien lacus, eu posuere odio luctus non. Nulla lacinia, eros vel fermentum consectetur, </p>
                        <h5>John Smith</h5>
                        <span>Themeforest</span> </div>
                </div>
            </div>
        </section>

        <!-- Clients -->
        <section class="clients light-gray-bg padding-top-60 padding-bottom-80">
            <div class="container-full">
                <div class="clients-slide">
                    <div> <img src="images/c-mg-1.png" alt="" > </div>
                    <div> <img src="images/c-mg-2.png" alt="" > </div>
                    <div> <img src="images/c-mg-3.png" alt="" > </div>
                    <div> <img src="images/c-mg-1.png" alt="" > </div>
                    <div> <img src="images/c-mg-2.png" alt="" > </div>
                    <div> <img src="images/c-mg-3.png" alt="" > </div>
                    <div> <img src="images/c-mg-1.png" alt="" > </div>
                    <div> <img src="images/c-mg-2.png" alt="" > </div>
                    <div> <img src="images/c-mg-3.png" alt="" > </div>
                </div>
            </div>
        </section>
    </div>
    @endsection