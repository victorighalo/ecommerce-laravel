@extends('layouts.main')

@section('content')
    @include('partials.hero')
    <main class="ps-main">
        <div class="ps-container">
            <div class="ps-product--detail">
                <div class="row">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 ">
                        <div class="ps-product__thumbnail">
                            <div class="ps-product__image">
                                @if($product->getMedia('images'))
                                    @foreach($product->getMedia('images') as $image)
                                       <div class="item">
                                            <a href="{{$image->getFullUrl()}}">
                                            <img src="{{$image->getFullUrl()}}" alt="{{$product->title()}}">
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="ps-product__preview">
                                <div class="ps-product__variants">
                                    @if($product->getMedia('images'))
                                        @foreach($product->getMedia('images') as $image)
                                            <div class="item">
                                                    <img src="{{$image->getFullUrl()}}" alt="{{$product->title()}}">
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="ps-video">
                                    <a class="popup-youtube ps-product__video" href="https://www.youtube.com/watch?v=meBbDqAXago">
                                        <img src="images/product/detail/variant-5.jpg" alt=""><i class="fa fa-play"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-5 col-sm-12 col-xs-12 ">
                        <div class="ps-product__info">
                            <div class="ps-product__rating">
                                <select class="ps-rating">
                                    <option value="1">1</option>
                                    <option value="1">2</option>
                                    <option value="1">3</option>
                                    <option value="1">4</option>
                                    <option value="2">5</option>
                                </select><a href="#">(Read all 8 reviews)</a>
                            </div>
                            <h1>{{$product->title()}}</h1>
                            <h1>{{$ratings}}</h1>
                            <p class="ps-product__category">
                                @if(isset($tags))
                                    @foreach($tags as $tag)
                                        <a href="#"><span class="badge badge-primary">{{$tag}}</span></a>
                                        @endforeach
                                    @endif
                            </p>
                            <h3 class="ps-product__price"> <span>&#8358;</span> {{number_format($product->price, '0', '.', ',')}}</h3>
                            <div class="ps-product__short-desc">
                                <p>{{$product->description}}</p>
                            </div>
                            <div class="ps-product__block ps-product__size">
                                <h4>CHOOSE QUANTITY</h4>
                                <div class="form-group ps-number">
                                    <input class="form-control" name="item_qty" type="text" value="1"><span class="up"></span><span class="down"></span>
                                </div>
                            </div>
                            <div class="ps-product__shopping">
                                <button class="ps-btn" data-slug="{{$product->slug}}" id="add_to_cart">
                                    <i class="fa fa-circle-o-notch fa-spin processing off" aria-hidden="true"></i> Add To Cart
                                </button>

                            </div>
                            <div class="ps-product__sharing">
                                <p>Share this:<a href="#"><i class="fa fa-facebook"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-dribbble"></i></a></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ps-product__content">
                    <ul class="tab-list" role="tablist">
                        <li class="active"><a href="#tab_01" aria-controls="tab_01" role="tab" data-toggle="tab">Overview</a></li>
                        <li><a href="#tab_02" aria-controls="tab_02" role="tab" data-toggle="tab">Review</a></li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active" role="tabpanel" id="tab_01">
                        <p>Caramels tootsie roll carrot cake sugar plum. Sweet roll jelly bear claw liquorice. Gingerbread lollipop dragée cake. Pie topping jelly-o. Fruitcake dragée candy canes tootsie roll. Pastry jelly-o cupcake. Bonbon brownie soufflé muffin.</p>
                        <p>Sweet roll soufflé oat cake apple pie croissant. Pie gummi bears jujubes cake lemon drops gummi bears croissant macaroon pie. Fruitcake tootsie roll chocolate cake Carrot cake cake bear claw jujubes topping cake apple pie. Jujubes gummi bears soufflé candy canes topping gummi bears cake soufflé cake. Cotton candy soufflé sugar plum pastry sweet roll..</p>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="tab_02">
                        <p>{{$product->commentCount()}} reviews for <strong>{{$product->title()}}</strong></p>
                        @if(isset($product))
                        @if(isset($product->comments))
                        @if(count($product->comments))
                            @foreach($product->comments as $comment)
                        <div class="ps-review">
                            <div class="ps-review__thumbnail"><img src="images/user/1.jpg" alt=""></div>
                            <div class="ps-review__content">
                                <header>
                                    <select class="ps-rating">
                                        <option value="1">1</option>
                                        <option value="1">2</option>
                                        <option value="1">3</option>
                                        <option value="1">4</option>
                                        <option value="5">5</option>
                                    </select>
                                    <p>By<a href=""> {{$comment->creator->firstname}}</a> - {{$comment->created_at->diffForHumans()}}</p>
                                </header>
                                <p>{{$comment->body}}</p>
                            </div>
                        </div>
                                    @endforeach
                        @endif
                        @endif
                        @endif
                        <form class="ps-form--product-review" action="{{route('add_comment', ['product_id' => $product->id])}}" method="post">
                            @csrf
                            <h4>ADD YOUR REVIEW</h4>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                    <div class="form-group">
                                        <label>Guest:<sup>*</sup></label>
                                    </div>
                                    <div class="form-group">
                                        <label>Title:<sup>*</sup></label>
                                        <input class="form-control" type="text" placeholder="" name="title">
                                    </div>
                                    <div class="form-group">
                                        <label>Your rating</label>
                                        <select class="ps-rating">
                                            <option value="1">1</option>
                                            <option value="1">2</option>
                                            <option value="1">3</option>
                                            <option value="1">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12 ">
                                    <div class="form-group">
                                        <label>Your Review:</label>
                                        <textarea class="form-control" rows="6" name="comment"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button class="ps-btn">Submit Reviews</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('script')
    <script>

        $(document).ready(function () {
            //load images to modal
            $(".processing").prop('disabled', true)
            $("#add_to_cart").click(function () {
                $(".processing").removeClass('off')
                $("#add_to_cart").prop('disabled', true)
                var slug = $(this).data('slug');
                var qty = $("input[name='item_qty']").val();
                if(qty < 1){
                    alert('Qty less than 1')
                    return false;
                }
                $.ajax({
                    url: "{{route('add_to_cart')}}",
                    type: 'POST',
                    data: {qty: qty, slug:slug}
                })
                    .done(function (data) {
                        $(".processing").addClass('off')
                        $("#add_to_cart").prop('disabled', false)
                        $(".cart_count").html("<i>"+data.cart_count+"</i>")
                        Snackbar.show({
                            showAction: true,
                            text: 'Cart updated.',
                            actionTextColor: '#ffffff',
                            backgroundColor:"#53A6E8"
                        });

                    }).fail(function (error) {
                    $(".processing").addClass('off')
                    $("#add_to_cart").prop('disabled', false)
                    Snackbar.show({
                        showAction: true,
                        text: 'Cart update failed!.',
                        actionTextColor: '#ffffff',
                        backgroundColor:"#FE970D"
                    });
                });
            });

        });

    </script>
    @endpush