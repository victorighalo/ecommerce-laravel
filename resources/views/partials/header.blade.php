
<header class="header" data-sticky="true">
    <div class="header__top">
        <div class="ps-container">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-6 col-xs-12 ">

                </div>
                <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12 ">
                    <div class="header__actions"><a href="#">Login & Regiser</a>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="navigation">
        <div class="ps-container"><a class="ps-logo" href="{{url('/')}}"><img src="images/logo.png" alt=""></a>
            <ul class="main-menu menu">
                <li class="current-menu-item"><a href="{{url('/')}}">Home</a>
                </li>
                <li class="menu-item-has-children"><a href="#">Categories</a>
                    <ul class="sub-menu">
                        @foreach($all_categories as $category)
                            @if($category->products->count() > 0)
                        <li class="menu-item-has-children">

                            <a href="{{route('getCategoryContent', ['taxon_slug' => $category->slug])}}">{{$category->name}} - {{$category->taxonomy->name}}</a>
                        </li>
                            @endif
                        @endforeach
                        {{--<li class="menu-item-has-children"><a href="whishlist.html">Other Pages</a>--}}
                            {{--<ul class="sub-menu">--}}
                                {{--<li><a href="cart.html">Shopping Cart</a></li>--}}
                                {{--<li><a href="404-page.html">404-page</a></li>--}}
                                {{--<li><a href="checkout.html">Checkout</a></li>--}}
                                {{--<li><a href="compare.html">Compare</a></li>--}}
                                {{--<li><a href="whishlist.html">Whishlist</a></li>--}}
                            {{--</ul>--}}
                        {{--</li>--}}
                    </ul>
                </li>
                <li><a href="{{url('about')}}">About</a></li>
                <li><a href="{{url('contact')}}">Contact</a></li>
            </ul>
            <div class="menu-toggle"><span></span></div>
            <div class="ps-cart"><a class="ps-cart__toggle" href="{{url('cart')}}"><span class="cart_count">
                        @if(isset($cart_count))
                        <i>{{$cart_count}}</i>
                            @else
                            0
                            @endif
                    </span><img src="images/market.svg" alt=""></a>
                {{--<div class="ps-cart__listing">--}}
                    {{--<div class="ps-cart__content">--}}
                        {{--<div class="ps-cart-item"><a class="ps-cart-item__close" href="#"></a>--}}
                            {{--<div class="ps-cart-item__thumbnail"><a href="product-detail.html"></a><img src="images/shopping-cart/1.jpg" alt=""></div>--}}
                            {{--<div class="ps-cart-item__content"><a class="ps-cart-item__title" href="product-detail.html">Kingsman</a>--}}
                                {{--<p><span>Quantity:<i>12</i></span><span>Total:<i>£176</i></span></p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="ps-cart-item"><a class="ps-cart-item__close" href="#"></a>--}}
                            {{--<div class="ps-cart-item__thumbnail"><a href="product-detail.html"></a><img src="images/shopping-cart/2.jpg" alt=""></div>--}}
                            {{--<div class="ps-cart-item__content"><a class="ps-cart-item__title" href="product-detail.html">Joseph</a>--}}
                                {{--<p><span>Quantity:<i>12</i></span><span>Total:<i>£176</i></span></p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="ps-cart-item"><a class="ps-cart-item__close" href="#"></a>--}}
                            {{--<div class="ps-cart-item__thumbnail"><a href="product-detail.html"></a><img src="images/shopping-cart/3.jpg" alt=""></div>--}}
                            {{--<div class="ps-cart-item__content"><a class="ps-cart-item__title" href="product-detail.html">Todd Snyder</a>--}}
                                {{--<p><span>Quantity:<i>12</i></span><span>Total:<i>£176</i></span></p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="ps-cart__total">--}}
                        {{--<p>Number of items:<span>36</span></p>--}}
                        {{--<p>Item Total:<span>£528.00</span></p>--}}
                    {{--</div>--}}
                    {{--<div class="ps-cart__footer"><a class="ps-btn" href="cart.html">Check out<i class="furniture-next"></i></a></div>--}}
                {{--</div>--}}
            </div>
            <form class="ps-form--search" action="do_action" method="post"><i class="furniture-search"></i>
                <input class="form-control" type="text" placeholder="Find product">
                <button>Search</button>
            </form>
        </div>
    </nav>
</header>
