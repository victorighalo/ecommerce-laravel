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

        <!-- OUR TEAM -->
        <section class="our-team light-gray-bg padding-top-100 padding-bottom-100">
            <div class="container">
                <div class="heading text-center">
                    <h4>Our Team</h4>
                    <hr>
                </div>

                <!-- TEAM -->
                <ul class="row">

                    <!-- Member -->
                    <li class="col-md-4 text-center animate fadeInUp" data-wow-delay="0.4s">
                        <article>
                            <!-- abatar -->
                            <div class="avatar"> <img class="img-circle" src="images/team-1.jpg" alt="" >
                                <!-- Team hover -->
                                <div class="team-hover">
                                    <div class="position-center-center">
                                        <div class="social-icons"> <a href="#."><i class="icon-social-facebook"></i></a> <a href="#."><i class="icon-social-twitter"></i></a> <a href="#."><i class="icon-social-dribbble"></i></a> </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Team Detail -->
                            <div class="team-names">
                                <h6>Mark Adnan</h6>
                                <p>CEO & FOUNDER</p>
                            </div>
                        </article>
                    </li>

                    <!-- Member -->
                    <li class="col-md-4 text-center animate fadeInUp" data-wow-delay="0.6s">
                        <article>
                            <!-- abatar -->
                            <div class="avatar"> <img class="img-circle" src="images/team-2.jpg" alt="" >
                                <!-- Team hover -->
                                <div class="team-hover">
                                    <div class="position-center-center">
                                        <div class="social-icons"> <a href="#."><i class="icon-social-facebook"></i></a> <a href="#."><i class="icon-social-twitter"></i></a> <a href="#."><i class="icon-social-dribbble"></i></a> </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Team Detail -->
                            <div class="team-names">
                                <h6>jennifer rod</h6>
                                <p>DESIGNER</p>
                            </div>
                        </article>
                    </li>

                    <!-- Member -->
                    <li class="col-md-4 text-center animate fadeInUp" data-wow-delay="0.8s">
                        <article>
                            <!-- abatar -->
                            <div class="avatar"> <img class="img-circle" src="images/team-3.jpg" alt="" >
                                <!-- Team hover -->
                                <div class="team-hover">
                                    <div class="position-center-center">
                                        <div class="social-icons"> <a href="#."><i class="icon-social-facebook"></i></a> <a href="#."><i class="icon-social-twitter"></i></a> <a href="#."><i class="icon-social-dribbble"></i></a> </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Team Detail -->
                            <div class="team-names">
                                <h6>natasha singh</h6>
                                <p>DEVELOPER</p>
                            </div>
                        </article>
                    </li>

                    <!-- Member -->
                    <li class="col-md-4 text-center">
                        <article>
                            <!-- abatar -->
                            <div class="avatar"> <img class="img-circle" src="images/team-4.jpg" alt="" >
                                <!-- Team hover -->
                                <div class="team-hover">
                                    <div class="position-center-center">
                                        <div class="social-icons"> <a href="#."><i class="icon-social-facebook"></i></a> <a href="#."><i class="icon-social-twitter"></i></a> <a href="#."><i class="icon-social-dribbble"></i></a> </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Team Detail -->
                            <div class="team-names">
                                <h6>Jahn Mark</h6>
                                <p>Product Designer</p>
                            </div>
                        </article>
                    </li>

                    <!-- Member -->
                    <li class="col-md-4 text-center">
                        <article>
                            <!-- abatar -->
                            <div class="avatar"> <img class="img-circle" src="images/team-5.jpg" alt="" >
                                <!-- Team hover -->
                                <div class="team-hover">
                                    <div class="position-center-center">
                                        <div class="social-icons"> <a href="#."><i class="icon-social-facebook"></i></a> <a href="#."><i class="icon-social-twitter"></i></a> <a href="#."><i class="icon-social-dribbble"></i></a> </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Team Detail -->
                            <div class="team-names">
                                <h6>jennifer rod</h6>
                                <p>Quality Head</p>
                            </div>
                        </article>
                    </li>

                    <!-- Member -->
                    <li class="col-md-4 text-center">
                        <article>
                            <!-- abatar -->
                            <div class="avatar"> <img class="img-circle" src="images/team-6.jpg" alt="" >
                                <!-- Team hover -->
                                <div class="team-hover">
                                    <div class="position-center-center">
                                        <div class="social-icons"> <a href="#."><i class="icon-social-facebook"></i></a> <a href="#."><i class="icon-social-twitter"></i></a> <a href="#."><i class="icon-social-dribbble"></i></a> </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Team Detail -->
                            <div class="team-names">
                                <h6>natasha singh</h6>
                                <p>DEVELOPER</p>
                            </div>
                        </article>
                    </li>
                </ul>
            </div>
        </section>

        <!-- Client Img  -->
        <section class="fun-facts padding-top-100 padding-bottom-80">
            <div class="container">

                <!-- HEADING -->
                <div class="heading text-center">
                    <h4>Few Facts About BoShop</h4>
                    <hr>
                </div>

                <!-- FUN FACTS -->
                <ul class="row">

                    <!-- SALES -->
                    <li class="col-sm-4"> <span>457</span>
                        <h5>Sales</h5>
                    </li>

                    <!-- Products -->
                    <li class="col-sm-4"> <span>571</span>
                        <h5>Items</h5>
                    </li>

                    <!-- Clients -->
                    <li class="col-sm-4"> <span>289</span>
                        <h5>Clients Worldwide</h5>
                    </li>
                </ul>
            </div>
        </section>

        <!-- TWEET -->
        <section class="tweet padding-top-100 padding-bottom-100">
            <div class="container">
                <div class="col-md-8 center-block"> <i class="icon-social-twitter"></i>
                    <p>Phasellus lacinia fermentum bibendum. Interdum et malesuada fames ac ante ipsumien lacus, eu posuere
                        eros vel fermentum consectetur, risus purus tempc, et iaculis odio dolor in ex. </p>
                    <span><span>@johnsmith</span> 4 hours ago via Twitter</span> </div>
            </div>
        </section>

        <!-- WORK WITH US -->
        <section class="our-team padding-top-100 padding-bottom-100">
            <div class="container">
                <div class="heading text-center">
                    <h4>We work with the best brands</h4>
                    <hr>
                </div>
            </div>
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