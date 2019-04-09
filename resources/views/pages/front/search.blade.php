@extends('layouts.main')

@section('content')
    @include('partials.hero', ['page' => 'Search'])
    <main class="ps-main">
        <div class="ps-container">
            <div class="ps-filter">
                <div class="row">
                    <div class="col-lg-12">
                        @if($products->count())
                        <div class="alert alert-info text-center">
                            <h3><i class="fa fa-search"></i> Search results: {{$title}}</h3>
                        </div>
                            @else
                            <div class="alert alert-dark text-center">
                                <h3><i class="fa fa-search"></i> Search results: No results found</h3>
                            </div>
                            @endif
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
                        <div class="ps-filter__trigger">
                            <div class="ps-filter__icon"><span></span></div>
                            <p>Filter Product</p>
                        </div>
                    </div>
                    {{--<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 ">--}}
                    {{--<div class="ps-filter__result">--}}
                    {{--<p>Showing 1–{{}} of {{}} results</p>--}}
                    {{--</div>--}}
                    {{--</div>--}}
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
                                {{--@if($product->created_at->diff($now)->days < 5)--}}
                                    {{--<div class="ps-badge"><span>New</span></div>--}}
                                {{--@endif--}}
                                {{--<div class="ps-badge ps-badge--sale">--}}
                                {{--<span>-35%</span></div>--}}
                                {{--<a class="ps-product__favorite" href="#">--}}
                                {{--<i class="furniture-heart"></i></a>--}}
                                @if ($product->getMedia('images')->first())
                                    <img src="{{env('APP_URL').$product->getMedia('images')->first()->getUrl()}}" alt="">
                                @endif
                                <a class="ps-product__overlay" href="{{route('getProductDetails', [
                            'taxon_slug' => $product->taxons->first()->slug,
                            'product_slug' => $product->slug
                            ])}}"></a>
                                <div class="ps-product__content full">
                                    <div class="ps-product__variants">
                                        @if($product->getMedia('images'))
                                            @foreach($product->getMedia('images') as $image)
                                                <div class="item"><img src="{{env('APP_URL').$image->getUrl()}}" alt=""></div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <select class="product-rating-home-view">
                                        @if( isset($product->averageRating) )
                                            @if( round($product->averageRating) > 0 )
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if($i <= round($product->averageRating()) )
                                                        <option value="1"></option>
                                                    @else
                                                        <option value="2"></option>
                                                    @endif
                                                @endfor
                                            @endif
                                        @else
                                            <option value=""></option>
                                            <option value="0"></option>
                                            <option value="2"></option>
                                            <option value="2"></option>
                                            <option value="2"></option>
                                            <option value="2"></option>
                                        @endif
                                    </select><a class="ps-product__title" href="{{route('getProductDetails', [
                            'taxon_slug' => $product->taxons->first()->slug,
                            'product_slug' => $product->slug
                            ])}}">{{$product->title()}}</a>
                                    <div class="ps-product__categories">
                                        <a href="{{route('getCategoryContent', ['slug' => $product->taxons->first()->slug])}}">
                                            {{$product->taxons->first()->name }} - {{$product->taxons->first()->taxonomy->name}}</a>
                                    </div>
                                    <p class="ps-product__price">
                                        &#8358;{{number_format($product->price, '0', '.', ',')}}
                                    </p>
                                    <button class="ps-btn add_to_cart" data-slug="{{$product->slug}}">
                                        <i class="fa fa-circle-o-notch fa-spin processing off" aria-hidden="true"></i> Add To Cart
                                    </button>
                                    {{--<p class="ps-product__feature"><i class="furniture-delivery-truck-2"></i>Free Shipping in 24 hours</p>--}}
                                </div>
                            </div>
                            <div class="ps-product__content">
                                <select class="product-rating-home-view">
                                    @if( isset($product->averageRating) )
                                        @if( round($product->averageRating) > 0 )
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if($i <= round($product->averageRating()) )
                                                    <option value="1"></option>
                                                @else
                                                    <option value="2"></option>
                                                @endif
                                            @endfor
                                        @endif
                                    @else
                                        <option value=""></option>
                                        <option value="0"></option>
                                        <option value="2"></option>
                                        <option value="2"></option>
                                        <option value="2"></option>
                                        <option value="2"></option>
                                    @endif
                                </select><a class="ps-product__title" href="{{route('getProductDetails', [
                            'taxon_slug' => $product->taxons->first()->slug,
                            'product_slug' => $product->slug
                            ])}}">{{$product->title()}}</a>
                                <div class="ps-product__categories"><a href="{{route('getCategoryContent', ['slug' => $product->taxons->first()->slug])}}">{{$product->taxons->first()->name }} - {{$product->taxons->first()->taxonomy->name}}</a></div>
                                <p class="ps-product__price">
                                    &#8358;{{number_format($product->price, '0', '.', ',')}}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="ps-pagination">

            <ul class="pagination">
                {{ $products->links('vendor.pagination.custom') }}
            </ul>
        </div>
    </main>
@endsection

@push('script')
    <script>
        $(document).ready(function () {

            $(".add_to_cart").click(function () {
                $(this).find(".processing").removeClass('off')
                $(this).prop('disabled', true)
                var slug = $(this).data('slug');
                var qty = 1;
                var self = this
                $.ajax({
                    url: "{{route('add_to_cart')}}",
                    type: 'POST',
                    data: {qty: qty, slug: slug}
                })
                    .done(function (data) {
                        $(self).find(".processing").addClass('off')
                        $(self).find(".processing").prop('disabled', false)
                        $(".cart_count").html("<i>" + data.cart_count + "</i>")
                        Snackbar.show({
                            showAction: true,
                            text: 'Cart updated.',
                            actionTextColor: '#ffffff',
                            backgroundColor: "#53A6E8"
                        });

                    }).fail(function (error) {
                    $(self).find(".processing").addClass('off')
                    $(self).find(".processing").prop('disabled', false)
                    Snackbar.show({
                        showAction: true,
                        text: 'Cart update failed!.',
                        actionTextColor: '#ffffff',
                        backgroundColor: "#FE970D"
                    });
                });
            });
        });
    </script>
@endpush