{{--<section class="home-slide" data-stellar-background-ratio="0.5">--}}
{{--    <div class="container">--}}
{{--        <!-- Item Slider -->--}}
{{--        <div class="single-slide">--}}

{{--            <!-- Slider Content -->--}}
{{--            <div class="owl-slide">--}}
{{--                <!-- Header Text -->--}}
{{--                @foreach($sliders as $slider)--}}
{{--                    @if($slider->photos)--}}
{{--                        @foreach($slider->photos as $image)--}}
{{--                            <img class="img-responsive card-img-top p-3" src="{{asset($image->LocalThumbImageUrl)}}">--}}

{{--                            <div class="text-left col-md-11 no-padding" style="background-image: url({{asset($image->LocalImageUrl)}})"> <span class="price"><small>$</small>299.99</span>--}}
{{--                    <h4>The Latest Winter Product for 2018</h4>--}}
{{--                    <h1 class="extra-huge-text">look hot with 2018 style</h1>--}}
{{--                    <div class="text-btn"> <a href="#." class="btn btn-inverse margin-top-40">SHOP NOW</a> </div>--}}
{{--                                @endforeach--}}
{{--                                @endif--}}
{{--                </div>--}}
{{--                    @endforeach--}}
{{--            </div>--}}

{{--        </div>--}}
{{--    </div>--}}
{{--</section>--}}
@if($sliders)
<div class="owl-carousel slick">
            @foreach($sliders as $image)
        <img src="{{asset($image->link)}}">

{{--        <div style="--}}
{{--                    background-image: url({{asset($image->link)}});--}}
{{--                    background-size: contain;--}}
{{--                    background-position: center center;--}}
{{--                    height: 100%;--}}
{{--                    background-repeat: no-repeat;--}}
{{--                    width: 100%;--}}
{{--                    ">--}}
{{--                </div>--}}
            @endforeach
</div>
@endif
