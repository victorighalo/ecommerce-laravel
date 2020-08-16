<section class="sub-bnr" data-stellar-background-ratio="0.5">
    <div class="position-center-center">
        <div class="container">
            <h4>{{$title ? ucfirst(strtolower($title)) : ''}}</h4>
            <ol class="breadcrumb">
                <li><a href="{{url('/')}}">Home</a></li>
                @if(isset($category))
                    <li>{{ucfirst(strtolower($category->parent->name))}}</li>
                    @if($category->parent)
                    <li class="active"><a a href="{{route('get_category_content', ['taxon_slug' => $category->parent->slug])}}" title="{{ucfirst(strtolower($category->parent->name))}}" >{{ucfirst(strtolower($category->parent->name))}}</a></li>
                    @endif
                    <li class="active"><a a href="{{route('get_category_content', ['taxon_slug' => $category->slug])}}" title="{{ucfirst(strtolower($category->name))}}" >{{ucfirst(strtolower($category->slug))}}</a></li>
                    @else
                    <li class="active">{{$title ? ucfirst(strtolower($title)) : ''}}</li>
                    @endif
            </ol>
        </div>
    </div>
</section>
