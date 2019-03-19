<div class="ps-section ps-home-categories">
    <div class="ps-container">
        <div class="ps-section__header text-center">
            <h3 class="ps-section__title">Shop by category</h3><span class="ps-section__line"></span>
        </div>
        <div class="ps-section__content ps-col-tiny">
            <div class="row">
                @foreach($categories as $category)
                    <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12 ">
                        <div class="ps-block--category" data-mh="category">
                            <a class="ps-block__overlay" href="{{route('getCategoryContent', ['taxon_slug' => $category->slug])}}"></a><i class="furniture-sofa-2"></i>
                            <a href="{{route('getCategoryContent', ['slug' => $category->slug])}}">{{$category->name}}</a>
                            <span class="badge badge-primary">{{$category->taxonomy->name}}</span>
                        </div>
                    </div>
                    @endforeach
            </div>
        </div>
        {{--<div class="ps-section__footer text-center"><a class="ps-btn" href="#">View all categories</a></div>--}}
    </div>
</div>