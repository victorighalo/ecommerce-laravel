<section class="light-gray-bg padding-top-100 padding-bottom-100">
    <div class="container-full">

        <!-- Main Heading -->
        <div class="heading text-center">
            <h4>Top categories</h4>
            {{--<span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec faucibus maximus vehicula. </span> --}}
        </div>

        <!-- New Arrival -->
        <div class="arrival-block list-group">
            <ul class="nav nav-tabs" role="tablist">
                @foreach($categories as $i => $category)
                    @if($category->products->count() > 0)
                        @if($i == 0)
                        <li class="nav-item"> <a class="active"  data-toggle="tab" href="#{{$category->taxonomy->name}}" role="tab" aria-selected="true">{{strtoupper($category->name)}} - {{strtoupper($category->taxonomy->name)}}</a> </li>
                        @else
                         <li class="nav-item"> <a class=""  data-toggle="tab" href="#{{$category->taxonomy->name}}" role="tab" aria-selected="true">{{strtoupper($category->name)}} - {{strtoupper($category->taxonomy->name)}}</a> </li>
                        @endif
                        @endif
                @endforeach
                  </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="arrival-tab">
            @foreach($categories as $index => $category)
                @if($category->products->count() > 0)
                    @if($index == 0)
                        <div class="tab-pane fade show active" id="{{$category->taxonomy->name}}" role="tabpanel">

                        @foreach($category->products->take(10) as $item)
                            @if($item->hasPhoto() && $item->isActive())
                            <!-- Item -->
                            <div class="item">
                                <div class="img-ser">
                                    <a href="{{route('getProductDetails', [
                            'taxon_slug' => $item->taxons->first()->slug,
                            'product_slug' => $item->slug
                            ])}}">
                                    <img
                                            class="img-1 lazyload"
                                            src="{{$item->FirstThumb}}"
                                            alt="{{$item->title()}}"
                                    >
                                    </a>

                                    <a href="{{route('getProductDetails', [
                            'taxon_slug' => $item->taxons->first()->slug,
                            'product_slug' => $item->slug
                            ])}}">
                                    <img class="img-2 lazyload" src="{{$item->FirstThumb}}" alt="">
                                    </a>

                                </div>
                                <!-- Item Name -->
                                <div class="item-name">
                                    <a  class="i-tittle"
                                        href="{{route('getProductDetails', [
                                                    'taxon_slug' => $item->taxons->first()->slug,
                                                    'product_slug' => $item->slug
                                                    ])}}">
                                        {{str_limit(strtoupper($item->title()),20, '...')}}
                                    </a>
                                    <span class="price"><small> &#8358;</small> {{number_format($item->price, '0', '.', ',')}}</span>
                                    <a  class="deta animated fadeInRight"
                                        href="{{route('getProductDetails', [
                                        'taxon_slug' => $item->taxons->first()->slug,
                                        'product_slug' => $item->slug
                            ])}}">
                            View Detail</a> </div>
                            </div>
                            @endif
                            @endforeach

                        </div>
                        @else
                            <div class="tab-pane animated fadeInDown" id="{{$category->taxonomy->name}}" role="tabpanel">

                            @foreach($category->products as $item)
                                @if($item->hasPhoto())
                                    <!-- Item -->
                                        <div class="item">
                                            <div class="img-ser">
                                                <img
                                                        class="img-1 lazyload"
                                                        src="{{$item->FirstThumb}}"
                                                        alt="{{$item->title()}}"
                                                >
                                                <img class="img-2 lazyload" src="{{$item->FirstThumb}}" alt="">

                                            </div>
                                            <!-- Item Name -->
                                            <div class="item-name">
                                                    <a  class="i-tittle"
                                                        href="{{route('getProductDetails', [
                                                    'taxon_slug' => $item->taxons->first()->slug,
                                                    'product_slug' => $item->slug
                                                    ])}}">
                                                        {{str_limit(strtoupper($item->title()),20, '...')}}
                                                    </a>
                                                <span class="price"><small> &#8358;</small> {{number_format($item->price, '0', '.', ',')}}</span>
                                                <a  class="deta animated fadeInRight"
                                                    href="{{route('getProductDetails', [
                                                    'taxon_slug' => $item->taxons->first()->slug,
                                                    'product_slug' => $item->slug
                                                    ])}}">
                                                    View Detail</a> </div>
                                        </div>
                                    @endif
                                @endforeach

                            </div>
                        @endif
                @endif
            @endforeach
            </div>
        </div>
    </div>
</section>