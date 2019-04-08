<div class="ps-section ps-home-best-product">
    <div class="ps-container">
        <div class="ps-section__header text-center">
            <h3 class="ps-section__title">LATEST PRODUCTS</h3><span class="ps-section__line"></span>
        </div>
        <div class="ps-section__content mt-100">
            <div class="row">
                @foreach($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 ">
                    <div class="ps-product">
                        <div class="ps-product__thumbnail">
                            <div class="ps-badge"><span>New</span></div>
                            {{--<div class="ps-badge ps-badge--sale"><span>-35%</span></div><a class="ps-product__favorite" href="#"><i class="furniture-heart"></i></a>--}}
                            @if($product->getMedia('images'))
                            <img src="{{env('APP_URL').$product->getMedia('images')->first()->getUrl()}}" alt="{{$product->title()}}">
                            @endif
                            <a class="ps-product__overlay" href="{{route('getProductDetails', [
                            'taxon_slug' => $product->taxons->first()->slug,
                            'product_slug' => $product->slug
                            ])}}">

                            </a>
                            <div class="ps-product__content full">
                                <div class="ps-product__variants">
                                    @if($product->getMedia('images'))
                                        @foreach($product->getMedia('images') as $image)
                                            <div class="item">
                                                <a href="{{$image->getFullUrl()}}">
                                                    <img src="{{env('APP_URL').$image->getUrl()}}" alt="{{$product->title()}}">
                                                </a>
                                            </div>
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
                                </select>
                                <a class="ps-product__title" href="{{route('getProductDetails', [
                            'taxon_slug' => $product->taxons->first()->slug,
                            'product_slug' => $product->slug
                            ])}}">{{$product->title()}}</a>
                                <div class="ps-product__categories">
                                    <a href="{{route('getCategoryContent', ['slug' => $product->taxons->first()->slug])}}">{{$product->taxons->first()->name}} - {{$product->taxons->first()->taxonomy->name}}</a></div>
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
                            </select>
                            <a class="ps-product__title" href="{{route('getProductDetails', [
                            'taxon_slug' => $product->taxons->first()->slug,
                            'product_slug' => $product->slug
                            ])}}">{{$product->title()}}</a>
                            <div class="ps-product__categories"><a href="{{route('getCategoryContent', ['slug' => $product->taxons->first()->slug])}}">{{$product->taxons->first()->name}} - {{$product->taxons->first()->taxonomy->name}}</a></div>
                            <p class="ps-product__price">
                                {{$product->delivery_price['amount']}}
                                &#8358;{{number_format($product->price, '0', '.', ',')}}
                            </p>
                        </div>
                    </div>
                </div>
                    @endforeach
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        $(document).ready(function () {

            $(".add_to_cart").click(function () {
                $(this).find(".processing").removeClass('off')
                $(this).prop('disabled', true)
                var slug = $(this).data('slug');
                var qty = 1
                var self = this;
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