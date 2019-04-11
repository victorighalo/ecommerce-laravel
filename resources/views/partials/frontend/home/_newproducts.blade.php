<section class="light-gray-bg padding-top-100 padding-bottom-100">
    <div class="container">

        <!-- Main Heading -->
        <div class="heading text-center">
            <h4>Newly added Products</h4>
            <hr>
        </div>

        <!-- Popular Item Slide -->
        <div class="papular-block block-slide-con">
        @foreach($latest_products as $product)
            <!-- Item -->
            <div class="item">
                {{--<!-- Sale -->--}}
                {{--<div class="on-sale"> Sale </div>--}}
                <!-- Item img -->
                <div class="item-img">
                    @if($product->getMedia('images'))
                        <img class="img-1" src="{{env('APP_URL').$product->getMedia('images')->first()->getUrl()}}" alt="{{$product->title()}}">
                        <img class="img-2" src="{{env('APP_URL').$product->getMedia('images')->first()->getUrl()}}" alt="{{$product->title()}}">
                    @endif

                </div>

                <!-- Item Name -->
                <div class="item-name">
                    <a href="{{route('getProductDetails', [
                            'taxon_slug' => $product->taxons->first()->slug,
                            'product_slug' => $product->slug
                            ])}}">{{$product->title()}} </a>
                    <p>{{$product->excerpt}}</p>
                </div>
                <!-- Price -->
                <span class="price"><small>&#8358;</small> {{number_format($product->price, '0', '.', ',')}}</span> </div>
            @endforeach

        </div>
    </div>
</section>
