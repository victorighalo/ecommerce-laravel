<div class="ps-section ps-home-best-product">
    <div class="ps-container">
        @foreach($categories as $category)
            @if($category->products->count() > 0)
            <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <a href="{{route('getCategoryContent', ['taxon_slug' => $category->slug])}}">{{$category->name}} - {{$category->taxonomy->name}}</a>
                </h3>
            </div>
                <div class="panel-body">
                    <div class="row">
                        @foreach($category->products as $item)
                            @if($item->getMedia('images')->first())
                            <div class="col-sm-2 products_by_category">
                                <a class="ps-product__overlay" href="{{route('getProductDetails', [
                            'taxon_slug' => $item->taxons->first()->slug,
                            'product_slug' => $item->slug
                            ])}}">
                                <img
                                        src="{{env('APP_URL').$item->getMedia('images')->first()->getUrl()}}"
                                        alt="{{$item->title()}}"
                                        class="img-responsive"
                                >
                                </a>
                                    <div class="product_title">
                                        <a class="ps-product__overlay" href="{{route('getProductDetails', [
                            'taxon_slug' => $item->taxons->first()->slug,
                            'product_slug' => $item->slug
                            ])}}">
                                {{str_limit(strtoupper($item->title()),20, '...')}}
                                        </a>
                                    </div>

                            </div>
                            @endif
                            @endforeach

                    </div>
                </div>
            </div>
            @endif
        @endforeach
</div>
</div>