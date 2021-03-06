@extends('layouts.newmain')

@section('content')

    <!--======= SUB BANNER =========-->
    @include('partials.frontend.sub_banner', ['title' => $title])
    <div id="content">
        <!-- Products -->
        <section class="shop-page padding-top-100 padding-bottom-100">
            <div class="container">
                <div class="row">

                    <!-- Item Content -->
                    <div class="col-md-9">
                        <!-- Item -->
                        <div id="products" class="arrival-block col-item-3 list-group">
                            @if(count($products))
                            <div class="row">
                            @foreach($products as $product)
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
                            </div>
                                @else
                                <div class="alert alert-info">
                                    <div class="container">
                                        <div class="alert-icon">
                                            <i class="fa fa-exclamation-circle"></i>
                                        </div>
                                        <h5>Products unavailable for category</h5>
                                    </div>
                                </div>
                                @endif
                        </div>


                        <!-- Pagination -->
                            {{ $products->links('vendor.pagination.custom') }}

                    </div>

                    <!-- Shop SideBar -->
                    <div class="col-md-3">
                        <div class="shop-sidebar">

                            <!-- Category -->
                            <h5 class="shop-tittle margin-bottom-30">categories</h5>
                            <ul class="shop-cate">
                                @if($categories)
                                    @foreach($categories as $category)
                                <li><a href="{{route('get_category_content', ['taxon_slug' => $category->slug])}}" > {{$category->name}} <span>{{count($category->products)}}</span></a></li>
                                    @endforeach
                                    @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @include('partials.frontend._search')

        {{--Product request--}}
        @include('partials.frontend.product_request')
    </div>
@endsection