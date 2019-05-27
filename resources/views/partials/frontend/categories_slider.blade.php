
<section class="clients light-gray-bg padding-top-60 padding-bottom-80">
    <div class="container">
        <h4 class="title text-center margin-bottom-30">Product Categories</h4>
        <div class="">
            @foreach($all_categories as $category)

                    <a href="{{route('get_category_content', ['taxon_slug' => $category->slug])}}" title="{{$category->name}}" class="text-capitalize font-16px">{{str_limit($category->name, 10)}}<span>({{count($category->products)}})  </span></a>

            @endforeach
        </div>
    </div>
</section>
</div>