<section class="padding-top-100 padding-bottom-100">
    <div class="container">

        <!-- About Sec -->
        <div class="acces-ser">
            <!-- Heading -->
            <div class="heading text-center">
                <h4>Available categories</h4>
                <hr>
            </div>
            <div class="row">
                @foreach($categories as $category)
                <div class="col-sm-2 col-xs-3 padding-10">
                    <a href="{{route('get_category_content', ['taxon_slug' => $category->slug])}}" class="btn by">{{$category->name}}</a>
                </div>
                    @endforeach

            </div>
        </div>
    </div>
</section>