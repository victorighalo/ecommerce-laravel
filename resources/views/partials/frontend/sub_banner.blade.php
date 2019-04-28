<section class="sub-bnr" data-stellar-background-ratio="0.5">
    <div class="position-center-center">
        <div class="container">
            <h4>{{$title ? $title : ''}}</h4>
            <ol class="breadcrumb">
                <li><a href="{{url('/')}}">Home</a></li>
                @if(isset($category))
                    <li>{{$category->taxonomy->name}}</li>
                    @if($category->parent)
                    <li class="active"><a a href="{{route('get_category_content', ['taxon_slug' => $category->parent->slug])}}" title="{{$category->parent->name}}" >{{$category->parent->name}}</a></li>
                    @endif
                    <li class="active"><a a href="{{route('get_category_content', ['taxon_slug' => $category->slug])}}" title="{{$category->name}}" >{{$category->slug}}</a></li>
                    @else
                    <li class="active">{{$title ? $title : ''}}</li>
                    @endif
            </ol>
        </div>
    </div>
</section>