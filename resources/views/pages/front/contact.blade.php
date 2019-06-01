@extends('layouts.newmain')

@section('content')

    <!--======= SUB BANNER =========-->
    @include('partials.frontend.sub_banner', ['title' => 'Contact us'])
    <div id="content">

        <!--======= CONATACT  =========-->
        <section class="contact padding-top-100 padding-bottom-100">
            <div class="container">
                <div class="contact-form">
                    <h5>Keep in Touch With Us</h5>
                    <div class="row">
                        <div class="col-md-8">

                            <!--======= Success Msg =========-->
                            <div id="contact_message" class="success-msg"> <i class="fa fa-paper-plane-o"></i>Thank You. Your Message has been Submitted</div>

                            <!--======= FORM  =========-->
                            <form role="form" id="contact_form" class="contact-form" method="post" onSubmit="return false">
                                <ul class="row">
                                    <li class="col-sm-6">
                                        <label>full name *
                                            <input type="text" class="form-control" name="name" id="name" placeholder="">
                                        </label>
                                    </li>
                                    <li class="col-sm-6">
                                        <label>Email *
                                            <input type="text" class="form-control" name="email" id="email" placeholder="">
                                        </label>
                                    </li>
                                    <li class="col-sm-6">
                                        <label>Phone *
                                            <input type="text" class="form-control" name="phone" id="phone" placeholder="">
                                        </label>
                                    </li>
                                    <li class="col-sm-6">
                                        <label>SUBJECT
                                            <input type="text" class="form-control" name="eubject" id="subject" placeholder="">
                                        </label>
                                    </li>
                                    <li class="col-sm-12">
                                        <label>Message
                                            <textarea class="form-control" name="message" id="message" rows="5" placeholder=""></textarea>
                                        </label>
                                    </li>
                                    <li class="col-sm-12">
                                        <button type="submit" value="submit" class="btn" id="btn_submit" onClick="proceed();">SEND MAIL</button>
                                    </li>
                                </ul>
                            </form>
                        </div>

                        <!--======= ADDRESS INFO  =========-->
                        <div class="col-md-4">
                            <div class="contact-info">
                                <h6>OUR ADDRESS</h6>
                                <ul>
                                    <li> <i class="icon-map-pin"></i>{{$app_settings->store_address ? $app_settings->store_address : ""}}</li>
                                    <li> <i class="icon-call-end"></i> {{$app_settings->store_phone ? $app_settings->store_phone : ""}}</li>
                                    <li> <i class="icon-envelope"></i> <a href="#." target="_top">{{$app_settings->store_email ? $app_settings->store_email : ""}}</a> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- About -->
        <section class="small-about">
            <div class="container-full">
                <div class="news-letter padding-top-150 padding-bottom-150">
                    <div class="row">
                        <div class="col-lg-6">
                            <h3>We always stay with our clients and respect their business. We deliver 100% and provide instant response to help them succeed in constantly changing and challenging business world. </h3>
                            <ul class="social_icons">
                                @if($app_settings->store_facebook != "")
                                    <li><a href="{{$app_settings->store_facebook}}"><i class="fa fa-facebook"></i></a></li>
                                @endif
                                @if($app_settings->store_twitter != "")
                                    <li><a href="{{$app_settings->store_twitter}}"><i class="fa fa-twitter"></i></a></li>
                                @endif
                                @if($app_settings->store_instagram != "")
                                    <li><a href="{{$app_settings->store_instagram}}"><i class="fa fa-instagram"></i></a></li>
                                @endif
                                @if($app_settings->store_youtube != "")
                                    <li><a href="{{$app_settings->store_youtube}}"><i class="fa fa-youtube"></i></a></li>
                                @endif
                                @if($app_settings->store_linkedin != "")
                                    <li><a href="{{$app_settings->store_linkedin}}"><i class="fa fa-linkedin"></i></a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @endsection