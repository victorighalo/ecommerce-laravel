@extends('layouts.newmain')

@section('content')

    <!--======= SUB BANNER =========-->
    @include('partials.frontend.sub_banner', ['title' => $title])
    <div id="content">
    @include('partials.frontend._search')
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
                        <div id="products" class="arrival-block col-item-3 list-group">
                                @foreach($categories as $category)
                                <div class="row">
                                    <h5>{{$category->name}}</h5>
                                @if(count($category->products))
                                @foreach($category->products as $product)
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
                                                        <img class="img-1" src="{{$product->FirstImage}}" alt="{{$product->title()}}">
                                                        <img class="img-2" src="{{$product->FirstImage}}" alt="{{$product->title()}}">
                                                @endif
                                                <!-- Overlay  -->

                                                </div>

                                                <!-- Item Name -->
                                                <div class="item-name fr-grd">
                                                    <a class="i-tittle" href="{{route('getProductDetails', [
                                            'taxon_slug' => $product->taxons->first()->slug,
                                            'product_slug' => $product->slug
                                            ])}}">{{$product->title()}}</a>
                                                    <span class="price"><small>&#8358;</small> {{number_format($product->price, '0', '.', ',')}}</span> <a class="deta animated fadeInRight"  href="{{route('getProductDetails', [
                                            'taxon_slug' => $product->taxons->first()->slug,
                                            'product_slug' => $product->slug
                                            ])}}">View Detail</a> </div>
                                                <!-- Item Details -->
                                                <div class="cap-text">
                                                    <div class="item-name">   <a class="i-tittle" href="{{route('getProductDetails', [
                                            'taxon_slug' => $product->taxons->first()->slug,
                                            'product_slug' => $product->slug
                                            ])}}">{{$product->title()}}</a> <span class="price"><small>&#8358;</small> {{number_format($product->price, '0', '.', ',')}}</span>

                                                        <p>{{$product->excerpt}}</p>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    @else
                                    <h6>Products unavailable for category</h6>
                                    @endif
                                </div>
                                @endforeach

                        </div>

                    </div>


                </div>
            </div>
        </section>

        {{--Product request--}}
        @include('partials.frontend.product_request')
    </div>
@endsection