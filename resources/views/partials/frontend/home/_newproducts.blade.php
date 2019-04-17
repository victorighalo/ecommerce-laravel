<section class="light-gray-bg padding-top-100 padding-bottom-100">
    <div class="container">

        <!-- Main Heading -->
        <div class="heading text-center">
            <h4>Newly Added Products</h4>
            <hr>
        </div>

        <!-- Popular Item Slide -->
        @if($latest_products)
        @if(count($latest_products) > 0)
        <div class="papular-block block-slide-con">
        @foreach($latest_products as $product)
            <!-- Item -->
            <div class="item">
                {{--<!-- Sale -->--}}
                <div class="on-sale"> New </div>
                <!-- Item img -->
                <div class="item-img">

                        <img class="img-1" src="{{$product->FirstImage}}" alt="{{$product->title()}}">
                        <img class="img-2" src="{{$product->FirstImage}}" alt="{{$product->title()}}">


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
            @endif
            @endif
    </div>
</section>