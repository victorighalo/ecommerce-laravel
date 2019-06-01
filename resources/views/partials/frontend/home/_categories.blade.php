<section class="padding-top-100 padding-bottom-100">
    <div class="container">

        <!-- About Sec -->
        <div class="acces-ser">
            <!-- Heading -->
            <div class="heading text-center">
                <h4>Brands</h4>
                <hr>
            </div>
            <div class="row">
                @foreach($brands as $brand)
                    <div class="col-sm-3 margin-bottom-20" >
                        <a href="{{route('get_brand', ['taxon_slug' => $brand->slug])}}" title="{{$brand->name}}">
                        <div style="background: url({{$brand->image}})" class="brands_container">
                    <p class="btn">
                        {{$brand->name}}
                    </p>
                    </div>
                        </a>
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