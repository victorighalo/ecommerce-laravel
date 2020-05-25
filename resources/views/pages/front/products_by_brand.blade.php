@extends('layouts.newmain')

@section('content')

    <!--======= SUB BANNER =========-->
    @include('partials.frontend.sub_banner', ['title' => $title])
    <div id="content">
    <!-- Products -->
        <section class="shop-page padding-top-100 padding-bottom-100">
            <div class="container">
                <div class="row">
                    <!-- Shop SideBar -->
                    <div class="col-md-2">
                        <div class="shop-sidebar">

                            <!-- Category -->
                            <h5 class="shop-tittle margin-bottom-30">categories</h5>

                            <ul class="shop-cate">
                                @if($categories)
                                    @foreach($categories as $category)
                                        <li><a href="{{route('get_category_content', ['taxon_slug' => $category->slug])}}" class="text-capitalize"> {{strtolower($category->name)}} <span>{{count($category->products)}}</span></a></li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>

                    <!-- Item Content -->
                    <div class="col-md-10">
                        <!-- Item -->
                        <div id="products" class="arrival-block col-item-3 list-group padding-40">
                                @foreach($categories as $category)
                                <section class="margin-bottom-30">
                                    <h5 class="border-bottom">
                                        <a href="{{route('get_category_content', ['taxon_slug' => $category->slug])}}" title="{{$category->name}}">
                                        {{$category->name}}
                                        </a>
                                    </h5>

                                @if(count($category->products))
                                @foreach($category->products->take(20) as $product)
                                    <!-- Item -->
                                        <div class="item">
                                            <div class="img-ser">
                                                <!-- Sale -->
                                                @if($product->created_at->diff($now)->days < 5)
                                                    <div class="on-sale"> New </div>
                                            @endif
                                            <!-- Images -->
                                                <div class="thumb">
                                                    @if($product->hasPhoto())
                                                        <a class="i-tittle" href="{{route('getProductDetails', [
                                            'taxon_slug' => $product->taxons->first()->slug,
                                            'product_slug' => $product->slug
                                            ])}}">
                                                        <img class="img-1" src="{{$product->FirstImage}}" alt="{{$product->title()}}">
                                                        <img class="img-2" src="{{$product->FirstImage}}" alt="{{$product->title()}}">
                                                        </a>
                                                @endif
                                                <!-- Overlay  -->

                                                </div>

                                                <!-- Item Name -->
                                                <div class="item-name fr-grd">
                                                    <a class="i-tittle" href="{{route('getProductDetails', [
                                            'taxon_slug' => $product->taxons->first()->slug,
                                            'product_slug' => $product->slug
                                            ])}}">{{substr($product->title(),0,20)}}</a>
                                                    <span class="price"><small>&#8358;</small> {{number_format($product->price, '0', '.', ',')}}</span> <a class="deta animated fadeInRight"  href="{{route('getProductDetails', [
                                            'taxon_slug' => $product->taxons->first()->slug,
                                            'product_slug' => $product->slug
                                            ])}}">View Detail</a> </div>
                                                <!-- Item Details -->
                                                <div class="cap-text">
                                                    <div class="item-name">   <a class="i-tittle" href="{{route('getProductDetails', [
                                            'taxon_slug' => $product->taxons->first()->slug,
                                            'product_slug' => $product->slug
                                            ])}}">{{substr($product->title(),0,20)}}</a> <span class="price"><small>&#8358;</small> {{number_format($product->price, '0', '.', ',')}}</span>

                                                        <p>{{substr($product->excerpt,0,20)}}</p>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    @else
                                    <h6>Products unavailable for category</h6>
                                    @endif
                                </section>
                                @endforeach

                        </div>

                    </div>


                </div>
            </div>
        </section>
{{--        @include('partials.frontend._search')--}}
        {{--Product request--}}
        @include('partials.frontend.product_request')
    </div>
@endsection
