<section class="clients padding-top-60 padding-bottom-60 theme-color-bg">
    <div class="container">
<form class="ps-form--search" action="{{url('search')}}" method="get">
    <div class="input-group mb-3">
    <input class="form-control" type="text" placeholder="Search for a Product" name="product">

    {{--<div class="input-group-append">--}}
        {{--<button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
            {{--<span>Select Category  <i class="fa fa-caret-down"></i></span>--}}
        {{--</button>--}}
        {{--<div class="dropdown-menu">--}}
            {{--<a class="dropdown-item" href="#">All</a>--}}
            {{--@foreach($brands as $brand)--}}
                {{--<a class="dropdown-item" href="#">  {{$brand->name}}</a>--}}
            {{--<div role="separator" class="dropdown-divider"></div>--}}
                {{--@foreach($brand->rootLevelTaxons() as $category)--}}
                    {{--<a href="{{route('get_category_content', ['taxon_slug' => $category->slug])}}" class="dropdown-item" title="{{$category->name}}">--}}
                        {{--{{$category->name}}--}}
                    {{--</a>--}}
                    {{--@endforeach--}}
                {{--@endforeach--}}
        {{--</div>--}}
        <button class="btn btn-outline-secondary" type="submit">Search <i class="fa fa-search"></i></button>

    </div>
</form>
        <p style="color: #fff;"><i class="fa fa-search"></i> <strong>Are you looking for a specific product?</strong>
        <br>Search for it using by typing in the product name in the search box above.
{{--        <br>Examples : Rims, Clutches, Mirrors, Compressors, Horns, Batteries.--}}
        </p>
</div>
</section>
