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
                                        <div class="on-sale"> Sale </div>
                                        @endif
                                        <!-- Images -->
                                        <div class="thumb">
                                            @if ($product->getMedia('images')->first())
                                                <img class="img-1" src="{{env('APP_URL').$product->getMedia('images')->first()->getUrl()}}" alt="{{$product->title()}}">
                                                <img class="img-2" src="{{env('APP_URL').$product->getMedia('images')->first()->getUrl()}}" alt="{{$product->title()}}">
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

        <!-- About -->
        <section class="small-about">
            <div class="container-full">
                <div class="news-letter padding-top-150 padding-bottom-150">
                    <div class="row">
                        <div class="col-lg-6">
                            <h3>We always stay with our clients and respect their business. We deliver 100% and provide instant response to help them succeed in constantly changing and challenging business world. </h3>
                            <ul class="social_icons">
                                <li><a href="#."><i class="icon-social-facebook"></i></a></li>
                                <li><a href="#."><i class="icon-social-twitter"></i></a></li>
                                <li><a href="#."><i class="icon-social-tumblr"></i></a></li>
                                <li><a href="#."><i class="icon-social-youtube"></i></a></li>
                                <li><a href="#."><i class="icon-social-dribbble"></i></a></li>
                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <h3>Subscribe Our Newsletter</h3>
                            <span>Phasellus lacinia fermentum bibendum. Interdum et malesuada fames ac.</span>
                            <form>
                                <input type="email" placeholder="Enter your email address" required>
                                <button type="submit">Subscribe</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Clients -->
        <section class="clients light-gray-bg padding-top-60 padding-bottom-80">
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