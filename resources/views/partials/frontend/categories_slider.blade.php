
<section class="clients light-gray-bg padding-top-60 padding-bottom-80">
    <div class="container-full">
        <h4 class="title text-center">Product Categories</h4>
        <div class="clients-slide">
            @foreach($all_categories as $category)
                <div>
                    <a href="{{route('get_category_content', ['taxon_slug' => $category->slug])}}" title="{{$category->name}}" class="btn by">{{str_limit($category->name, 10)}}</a>
                </div>
            @endforeach
        </div>
    </div>
</section>
</div>