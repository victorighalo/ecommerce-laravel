<section class="padding-top-100 padding-bottom-100">
    <div class="container">

        <!-- About Sec -->
        <div class="acces-ser">
            <!-- Heading -->
            <div class="heading text-center">
                <h4>Our Categories</h4>
                <hr>
            </div>
            <div class="row">
                @foreach($categories as $category)
                <div class="col-sm-2 col-xs-3 padding-10">
                    <a href="{{route('get_category_content', ['taxon_slug' => $category->slug])}}" title="{{$category->name}}" class="btn by">{{str_limit($category->name, 10)}}</a>
                </div>
                    @endforeach
            </div>

            <div class="row">
                <div class="col-sm-12 text-center mt-5">
                    <a href="{{url('categories')}}" class="btn btn-primary">View More</a>
                </div>
            </div>
        </div>
    </div>
</section>