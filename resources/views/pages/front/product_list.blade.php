@extends('layouts.main')

@section('content')
    @include('partials.hero')
    <main class="ps-main">
        <div class="ps-container">
            <div class="ps-filter">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12 ">
                        <div class="ps-filter__trigger">
                            <div class="ps-filter__icon"><span></span></div>
                            <p>Filter Product</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 ">
                        <div class="ps-filter__result">
                            <p>Showing 1–12 of 35 results</p>
                        </div>
                    </div>
                </div>
                <div class="ps-filter__content">
                    <div class="ps-filter__column" data-mh="column">
                        <h3>SORT CATEGORIES BY</h3>
                        <ul class="ps-list--filter">
                            <li class="current"><a href="product-listing.html">All</a></li>
                            <li><a href="product-listing.html">Men</a></li>
                            <li><a href="product-listing.html">Women</a></li>
                            <li><a href="product-listing.html">Suite & Jean</a></li>
                            <li><a href="product-listing.html">Accessories</a></li>
                            <li><a href="product-listing.html">Kids</a></li>
                            <li><a href="product-listing.html">Handmade</a></li>
                        </ul>
                    </div>
                    <div class="ps-filter__column" data-mh="column">
                        <h3>SORT PRODUCTS BY</h3>
                        <ul class="ps-list--filter">
                            <li class="current"><a href="product-listing.html">Default Sorting</a></li>
                            <li><a href="product-listing.html">Sort by popularity</a></li>
                            <li><a href="product-listing.html">Sort by average rating</a></li>
                            <li><a href="product-listing.html">Sort by newness</a></li>
                            <li><a href="product-listing.html">Sort by price: low to high</a></li>
                            <li><a href="product-listing.html">Sort by price: high to low</a></li>
                        </ul>
                    </div>
                    <div class="ps-filter__column" data-mh="column">
                        <h3>FILTER BY PRICE</h3>
                        <ul class="ps-list--filter">
                            <li class="current"><a href="product-listing.html">All</a></li>
                            <li><a href="product-listing.html">£10.00 - £110.00</a></li>
                            <li><a href="product-listing.html">£110.00 - £210.00</a></li>
                            <li><a href="product-listing.html">£210.00 - £310.00</a></li>
                            <li><a href="product-listing.html">£310.00+</a></li>
                        </ul>
                    </div>
                    <div class="ps-filter__column" data-mh="column">
                        <h3>FILTER BY PRICE</h3>
                        <ul class="ps-list--color">
                            <li><a href="#"></a></li>
                            <li><a href="#"></a></li>
                            <li><a href="#"></a></li>
                            <li><a href="#"></a></li>
                            <li><a href="#"></a></li>
                            <li><a href="#"></a></li>
                            <li><a href="#"></a></li>
                            <li><a href="#"></a></li>
                            <li><a href="#"></a></li>
                            <li><a href="#"></a></li>
                            <li><a href="#"></a></li>
                            <li><a href="#"></a></li>
                        </ul>
                    </div>
                    <div class="ps-filter__column" data-mh="column">
                        <h3>FILTER BY PRICE</h3>
                        <ul class="ps-list--filter">
                            <li class="current"><a href="product-listing.html">All</a></li>
                            <li><a href="product-listing.html">New</a></li>
                            <li><a href="product-listing.html">SaleOff</a></li>
                            <li><a href="product-listing.html">Show Only Products On Sale</a></li>
                            <li><a href="product-listing.html">In Stock Only</a></li>
                            <li><a href="product-listing.html">Out of stock</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 ">
                    <div class="ps-product">
                        <div class="ps-product__thumbnail">
                            @if($product->created_at->diff($now)->days < 5)
                            <div class="ps-badge"><span>New</span></div>
                            @endif
                            {{--<div class="ps-badge ps-badge--sale">--}}
                                {{--<span>-35%</span></div>--}}
                            <a class="ps-product__favorite" href="#">
                                <i class="furniture-heart"></i></a>
                            @if ($product->getMedia('images')->first())
                            <img src="{{$product->getMedia('images')->first()->getFullUrl()}}" alt="">
                            @endif
                            <a class="ps-product__overlay" href="{{route('getProductDetails', [
                            'taxon_slug' => $product->taxons->first()->slug,
                            'product_slug' => $product->slug
                            ])}}"></a>
                            <div class="ps-product__content full">
                                <div class="ps-product__variants">
                                    @if($product->getMedia('images'))
                                    @foreach($product->getMedia('images') as $image)
                                    <div class="item"><img src="{{$image->getFullUrl()}}" alt=""></div>
                                        @endforeach
                                        @endif
                                </div>
                                <select class="ps-rating">
                                    <option value="1">1</option>
                                    <option value="1">2</option>
                                    <option value="1">3</option>
                                    <option value="1">4</option>
                                    <option value="2">5</option>
                                </select><a class="ps-product__title" href="product-detail">{{$product->title()}}</a>
                                <div class="ps-product__categories"><a href="product-listing.html">Armchair</a></div>
                                <p class="ps-product__price">
                                    <del>£220</del>£120
                                </p><a class="ps-btn ps-btn--sm" href="product-detail">Add to cart</a>
                                <p class="ps-product__feature"><i class="furniture-delivery-truck-2"></i>Free Shipping in 24 hours</p>
                            </div>
                        </div>
                        <div class="ps-product__content">
                            <select class="ps-rating">
                                <option value="1">1</option>
                                <option value="1">2</option>
                                <option value="1">3</option>
                                <option value="1">4</option>
                                <option value="2">5</option>
                            </select><a class="ps-product__title" href="product-detail">{{$product->title()}}</a>
                            <div class="ps-product__categories"><a href="product-listing.html">Armchair</a></div>
                            <p class="ps-product__price">
                                <del>£220</del>£120
                            </p>
                        </div>
                    </div>
                </div>
                    @endforeach
            </div>
        </div>
        <div class="ps-pagination">
            <ul class="pagination">
                <li><a href="#"><i class="fa fa-angle-left"></i></a></li>
                <li class="active"><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">...</a></li>
                <li><a href="#"><i class="fa fa-angle-right"></i></a></li>
            </ul>
        </div>
    </main>
@endsection