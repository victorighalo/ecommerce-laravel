<footer>
    <div class="container-full">
        <div class="insta-g">
            <div class="text-center">
                <h3>Follow us</h3>
            </div>
            <div class="padding-20">
            <ul class="justify-content-center d-flex text-center sm">
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
    <div class="clearfix"></div>
    <div class="container">
        <div class="row">
            <!-- ABOUT Location -->
            <div class="col-md-4">
                <div class="about-footer"> <img class="margin-bottom-30" src="images/logo-foot.png" alt="" >
                    <p><i class="icon-pointer"></i> {{$app_settings->store_address ? $app_settings->store_address : ""}}</p>
                    <p><i class="icon-call-end"></i> {{$app_settings->store_phone ? $app_settings->store_phone : ""}}</p>
                    <p><i class="icon-envelope"></i>  {{$app_settings->store_email ? $app_settings->store_email : ""}}</p>
                </div>
            </div>

            {{--<!-- HELPFUL LINKS -->--}}
            {{--<div class="col-md-5">--}}
                {{--<h6>Links</h6>--}}
                {{--<ul class="link two-half">--}}
                    {{--<li><a href="{{url('about')}}"> About</a></li>--}}
                    {{--<li><a href="#."> Find a Store</a></li>--}}
                    {{--<li><a href="#."> Features</a></li>--}}
                    {{--<li><a href="#."> Privacy Policy</a></li>--}}
                    {{--<li><a href="#."> Blog</a></li>--}}
                    {{--<li><a href="#."> Press Kit </a></li>--}}
                    {{--<li><a href="#."> Products</a></li>--}}
                    {{--<li><a href="#."> Find a Store</a></li>--}}
                    {{--<li><a href="#."> Features</a></li>--}}
                    {{--<li><a href="#."> Privacy Policy</a></li>--}}
                    {{--<li><a href="#."> Blog</a></li>--}}
                    {{--<li><a href="#."> Press Kit </a></li>--}}
                {{--</ul>--}}
            {{--</div>--}}

            {{--<!-- HELPFUL LINKS -->--}}
            {{--<div class="col-md-3">--}}
                {{--<h6>Account Info</h6>--}}
                {{--<ul class="link">--}}
                    {{--<li><a href="#."> Products</a></li>--}}
                    {{--<li><a href="#."> Find a Store</a></li>--}}
                    {{--<li><a href="#."> Features</a></li>--}}
                    {{--<li><a href="#."> Privacy Policy</a></li>--}}
                    {{--<li><a href="#."> Blog</a></li>--}}
                    {{--<li><a href="#."> Press Kit </a></li>--}}
                {{--</ul>--}}
            {{--</div>--}}
        </div>
    </div>

    <!-- Rights -->
    <div class="rights">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p>©  2019 - {{date('Y')}} {{$app_settings->store_name}} All right reserved. <a href="">{{$app_settings->store_name}}</a></p>
                </div>
                <div class="col-md-6 text-right"> <img src="images/card-icon.png" alt="" > </div>
            </div>
        </div>
    </div>
</footer>