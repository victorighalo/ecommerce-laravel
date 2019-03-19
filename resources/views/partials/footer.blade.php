<footer class="ps-footer site-footer">
    <div class="ps-footer__content">
        <div class="ps-container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                    <div class="ps-site-info site-info"><a class="ps-logo" href="{{url('/')}}"><img src="images/logo.png" alt=""></a>
                        <p>{{$app_settings->store_description}}</p>
                        <div class="ps-site-info__contact">
                            <h4>Contact Info</h4>
                            <p>{{$app_settings->store_address}}</p>
                            <p>{{$app_settings->store_phone}}</p>
                        </div>
                        <ul class="ps-social">
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
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
                            <div class="widget widget_footer widget_worktime">
                                <h2 class="widget-title">Working Hours<span></span></h2>
                                <p>Monday - Friday <br> 08:00 am - 08:30 pm</p><p> ==== </p>
                                <p>Satuday - Sunday <br> 10:00 am - 4:30 pm</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
                            <div class="ps-widget ps-widget--footer widget widget_footer">
                                <h2 class="widget-title">Your Account<span></span></h2>
                                <ul class="ps-list--line">
                                    <li><a href="#">Track order</a></li>
                                    <li><a href="#">Newsletter</a></li>
                                    <li><a href="#">Information</a></li>
                                    <li><a href="#">Payment menthod</a></li>
                                    <li><a href="#">Your wishlist</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ps-footer__copyright">
        <div class="ps-container">
            <div class="row">
                <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 ">
                    <p>&copy; Copyright by <span>{{$app_settings->store_name}}</span>.</p>
                </div>
                <div class="col-lg-4 col-md-5 col-sm-12 col-xs-12 ">
                    <div class="ps-footer__payment-methods"><a href="#"><img src="images/payment-method/paypal.png" alt=""></a><a href="#"><img src="images/payment-method/visa.png" alt=""></a><a href="#"><img src="images/payment-method/master-card.png" alt=""></a></div>
                </div>
            </div>
        </div>
    </div>
</footer>
<div class="ps-loading"><div class="loader ">
        <div class="loader__item"></div>
        <div class="loader__item"></div>
        <div class="loader__item"></div>
        <div class="loader__item"></div>
        <div class="loader__item"></div>
    </div>