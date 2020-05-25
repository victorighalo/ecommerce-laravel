
<section class="clients light-gray-bg padding-top-60 padding-bottom-80">
    <div class="container">
        <h3 class=" text-center margin-bottom-30">Product Categories</h3>
        <div class="">
            @foreach($all_categories as $category)
                <div class="d-inline font-weight-bold shadow-sm bg-gray-300 p-2 m-2 rounded cursor-pointer">
                <a href="{{route('get_category_content', ['taxon_slug' => $category->slug])}}" title="{{$category->name}}" class="text-capitalize font-16px; margin-bottom-15">{{$category->name}}
                    <span class='bg-gray-100 p-2 m-2'>{{count($category->products)}}</span>
                </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
</div>
