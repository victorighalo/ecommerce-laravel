<section class="padding-top-100 padding-bottom-100">
    <div class="container">

        <!-- About Sec -->
        <div class="acces-ser">
            <!-- Heading -->
            <div class="row">
                @foreach($categories as $category)
                <div class="col-sm-4">
                    <article> <img class="img-responsive" src="images/access-img-1.jpg" alt="" >
                        <h6>{{$category->taxonomy->name}}</h6>
                        <a href="{{route('getCategoryContent', ['taxon_slug' => $category->slug])}}" class="btn by">Shop NOW</a> </article>
                    <a href="{{route('getCategoryContent', ['slug' => $category->slug])}}" class="btn by">{{$category->name}}</a>
                </div>
                    @endforeach

            </div>
        </div>
    </div>
</section>