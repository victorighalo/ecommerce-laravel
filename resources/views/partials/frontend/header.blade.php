<?php
function nav_menu($array){

$ul = "<ul class='dropdown-menu'>";
      foreach($array as $category){
        $ul .= "<li>";
        $ul .= "<a href=".route('get_category_content', ['taxon_slug' => $category->slug])." title=".$category->name." class='dropdown-toggle' data-toggle='dropdown'>";
        $ul .= $category->name;
        $ul .= "</a>";
        if(count($category->children)){
            $ul .= sub_menu($category->children);
        }
        $ul .= "</li>";
      }
$ul .= "</ul>";
return $ul;
}

//function nav_menu($array){
//
//$ul = " <ul class=\"dropdown-menu animated-3s fadeInLeft\">";
//      foreach($array as $category){
//        $ul .= "<li>";
//        $ul .= "<a href=".route('get_category_content', ['taxon_slug' => $category->slug])." title=".$category->name." style='text-decoration: underline !important; font-weight: bold'>";
//        $ul .= $category->name;
//        $ul .= "</a>";
////        if(count($category->children)){
////            $ul .= sub_menu($category->children);
////        }
//        $ul .= "</li>";
//      }
//$ul .= "</ul>";
//return $ul;
//}

function sub_menu($array){

    $ul = " <div class='dropdown-menu'>";
    $ul .= " <div class='row'>";
    $ul .= " <ul class='col-sm-6'>";
    foreach($array as $category){
        $ul .= "<li>";
        $ul .= "<a href=".route('get_category_content', ['taxon_slug' => $category->slug])." title=".$category->name.">";
        $ul .= $category->name;
        $ul .= "</a>";
        if(count($category->children)){
            $ul .= nav_menu($category->children);
        }
        $ul .= "</li>";
    }
    $ul .= "</ul>";
    $ul .= "</div>";
    $ul .= "</div>";
    return $ul;
}

?>

<div class="top-bar">
    <div class="container-full">
        <p><i class="icon-map-pin"></i> {{$app_settings->store_address ? $app_settings->store_address : ""}} </p>
        <p class="call"> <i class="icon-call-in"></i> {{$app_settings->store_phone ? $app_settings->store_phone : ""}} </p>

        <!-- Login Info -->
        <div class="login-info">
            <ul>
                <li><a href="{{url('cart')}}">MY CART</a></li>      <!-- USER BASKET -->
                <li class="dropdown user-basket"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"> {{Cart::itemCount()}} Items <i class="icon-basket-loaded"></i> </a>
                    <ul class="dropdown-menu">
                        @foreach(Cart::getItems() as $item)
                        <li>
                            <div class="media-left">
                                <div class="cart-img"> <a href="#"> <img class="media-object img-responsive" src="{{$item->product->FirstImage}}" alt="{{$item->product->name}}"> </a> </div>
                            </div>
                            <div class="media-body">
                                <h6 class="media-heading">{{$item->product->name}}</h6>
                                <span class="price"><small>&#8358;</small> {{number_format($item->price, '0', '.', ',')}}</span> <span class="qty">QTY: {{$item->quantity}}</span> </div>
                        </li>
                        @endforeach
                        <li class="margin-0">
                            <div class="row">
                                <div class="col-sm-6"> <a href="{{url('cart')}}" class="btn">VIEW CART</a></div>
                                <div class="col-sm-6 "> <a href="{{url('checkout')}}" class="btn">CHECK OUT</a></div>
                            </div>
                        </li>
                    </ul>
                </li>

                @guest
                <li><a href="{{url('login')}}">LOGIN</a></li>
                <li><a href="{{url('register')}}">REGISTER</a></li>
                @else
                    <li><a href="#."> MY ACCOUNT </a></li>
                    <li>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('LOGOUT') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                @endguest
                <li> <a href="{{url('about')}}">ABOUT US </a> </li>
                <li> <a href="{{url('contact')}}"> CONTACT</a> </li>
            </ul>
        </div>
    </div>
</div>
<header class="sticky">
    <div class="container">
{{--        <pre>--}}
{{--        @php(var_dump($brands[0]->rootLevelTaxons()[0]->children ))--}}
{{--</pre>--}}
        <!-- Logo -->
{{--        <div class="logo"> <a href="{{url('/')}}"><img class="img-responsive" src="{{asset('assets/images/big-stan-logo.png')}}" alt="logo" style="width: 50%" ></a> </div>--}}
        <div class="logo"> <a href="{{url('/')}}">{{$app_settings->store_name}}</a> </div>
        <nav class="navbar ownmenu navbar-expand-lg">
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"> <span></span> </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="nav">
                    {{--<li> <a href="{{url('/')}}">Home</a></li>--}}
                    @foreach($brands as $brand)
                        <li class="dropdown"> <a href="{{route('get_brand', ['taxon_slug' => $brand->slug])}}" title="{{$brand->name}}"> {{$brand->name}} </a>
                    @if($brand->rootLevelTaxons()->count())
                            <?php
                            echo nav_menu($brand->rootLevelTaxons());
                            ?>
                        @endif
                        </li>
                        @endforeach

                </ul>
            </div>

            <!-- Nav Right -->
            <div class="nav-right">
                <ul class="navbar-right">
                    <!-- USER INFO -->
                    <li> <a href="{{url('profile')}}"><i class="lnr lnr-user"></i> </a></li>
                    <!-- USER BASKET -->
                    <li> <a href="{{url('cart')}}"><span class="c-no">{{Cart::itemCount()}}</span><i class="lnr lnr-cart"></i> </a> </li>
                    <!-- SEARCH BAR -->
                    <li> <a href="javascript:void(0);" class="search-open"><i class="lnr lnr-magnifier"></i></a>
                        <div class="search-inside animated bounceInUp"> <i class="icon-close search-close"></i>
                            <div class="search-overlay"></div>
                            <div class="position-center-center">
                                <div class="search">
                                    <form action="{{url('search')}}" method="get">
                                        <input type="search" placeholder="Search Shop" name="product">
                                        <button type="submit"><i class="icon-check"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <div class="clearfix"></div>
</header>
