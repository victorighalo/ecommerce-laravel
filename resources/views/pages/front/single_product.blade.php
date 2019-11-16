@extends('layouts.newmain')

@section('content')

<!--======= SUB BANNER =========-->
@include('partials.frontend.sub_banner', ['category' => $product->taxons->first()])

<!-- Content -->
<div id="content">

    <!-- Popular Products -->
    <div id="modal-center" class="uk-flex-top product-to-cart" uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">

            <button class="uk-modal-close-default" type="button" uk-close></button>
            <h4 class="text-center"><span class="text-bold">{{$product->title()}}</span> <span class="cart-msg"></span></h4>
            <div class="text-center">
            <a class="uk-button uk-button-default close-modal" href="#">CONTINUE SHOPPING</a>
            <a class="uk-button uk-button-primary" href="{{url('cart')}}">VIEW CART AND CHECKOUT</a>
            </div>
        </div>
    </div>
    <section class="padding-top-100 padding-bottom-100">
        <div class="container">

            <!-- SHOP DETAIL -->
            <div class="shop-detail">
                <div class="row">
                <div class="col-md-12">
                    @if (session('status'))
                        <div class="alert alert-success">
                            <div class="container">
                                <div class="alert-icon">
                                    <i class="fa fa-check"></i>
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"><i class="fa fa-close"></i></span>
                                </button>
                                {{ session('status') }}
                            </div>
                        </div>
                    @endif
                    @if (session('error'))
                            <div class="alert alert-danger">
                                <div class="container">
                                    <div class="alert-icon">
                                        <i class="fa fa-exclamation-circle"></i>
                                    </div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true"><i class="fa fa-close"></i></span>
                                    </button>
                                    {{ session('error') }}
                                </div>
                            </div>
                    @endif
                </div>

                            <!-- Popular Images Slider -->
                    <div class="col-md-7">
                        <!-- Place somewhere in the <body> of your page -->
                        <div id="slider-shop" class="flexslider">
                            <ul class="slides">
                                @if($product->photos)
                                    @foreach($product->photos as $image)
                                        <li> <img class="img-responsive" src="{{asset($image->ImageUrl)}}" alt="{{$product->title()}}" onerror="this.src='{{asset('assets/images/image-placeholder.png')}}'"> </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <div id="shop-thumb" class="flexslider">
                            <ul class="slides">
                                @if($product->photos)
                                    @foreach($product->photos as $image)
                                        <li> <img class="img-responsive" src="{{asset($image->ImageUrl)}}" alt="{{$product->title()}}" onerror="this.src='{{asset('assets/images/image-placeholder.png')}}'"> </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>

                    <!-- COntent -->
                    <div class="col-md-5">
                        <h4>{{$product->title()}}</h4>
                        <select class="product-rating-view">
                            @for ($i = 0; $i < 5; $i++)
                                @if($i <= $ratings )
                                    <option value="1"></option>
                                @else
                                    <option value="2"></option>
                                @endif
                            @endfor
                        </select>

                        <span class="price"><small>&#8358;</small> {{number_format($product->price, '0', '.', ',')}}</span>
                        <ul class="item-owner">
                            <li>Category:<span> {{$product->taxons->first()->slug}}</span></li>
                            <li>Tags:
                                @if(isset($tags))
                                    @foreach($tags as $tag)
                                        <span class="badge badge-primary text-white">{{$tag}}</span>
                                    @endforeach
                                @endif
                            </li>
                            <li>
                                @if(isset($product->propertyValues))
                                    @foreach($product->propertyValues as $propertyValue)
                                        {{ $propertyValue->property->name }}: <span class="font-weight-bold text-white"
                                        style="color: #000 !important;padding-right: 10px;font-size: 14px">{{ ucfirst($propertyValue->value) }}</span>
                                    @endforeach
                                @endif
                            </li>
                        </ul>
                        <!-- Item Detail -->
                        <p>{{$product->meta_description}}</p>


                        <!-- Short By -->
                        <div class="some-info">
                            @if($product->is_variant)
                            <div class="row margin-top-30 padding-10 justify-content-center">
                                    @foreach($product->variants() as $variant)
                                    <div class="col-sm-3" id="product_variants">
                                        <select name="{{$variant['option_slug']}}" id="" class="form-control"  data-option_id="{{$variant['option_id']}}"
                                                data-option_name="{{$variant['option_name']}}">
                                            <option value="null" selected>{{$variant['option_name']}}</option>
                                            @foreach($variant['option_values'] as $option_value)
                                                <option
                                                    value="{{$option_value['option_value_id']}}"
                                                    data-option_id="{{$variant['option_id']}}"
                                                    data-option_name="{{$variant['option_name']}}"
                                                    data-option_value_id="{{$option_value['option_value_id']}}"
                                                    data-option_value_name="{{$option_value['option_value_name']}}"
                                                >
                                                    {{$option_value['option_value_name']}}
                                                </option>
                                            @endforeach
                                    </select>
                                    </div>
                                    @endforeach
                            </div>
                            @endif
                            <ul class="row margin-top-30">
                                <li class="col-sm-12">
                                    <!-- Quantity -->
                                    <div class="quinty">
                                        <button type="button" class="quantity-left-minus"  data-type="minus" data-field=""> <span>-</span> </button>
                                        <input type="number" id="quantity" name="item_qty" class="form-control input-number" value="1">
                                        <button type="button" class="quantity-right-plus" data-type="plus" data-field=""> <span>+</span> </button>
                                    </div>
                                </li>

                                <!-- ADD TO CART -->
                                <li class="col-sm-12"> <button href="" class="btn" data-slug="{{$product->slug}}" id="add_to_cart"> <i class="fa fa-circle-o-notch fa-spin processing off" aria-hidden="true"></i> ADD TO CART</button> </li>
                            </ul>

                            <!-- INFOMATION -->
                            <div class="inner-info">
                                <h5>Share this item with your friends</h5>
                                <!-- Social Icons -->
                                <ul class="social_icons">
                                    <li><a href="#."><i class="icon-social-facebook"></i></a></li>
                                    <li><a href="#."><i class="icon-social-twitter"></i></a></li>
                                    <li><a href="#."><i class="icon-social-tumblr"></i></a></li>
                                    <li><a href="#."><i class="icon-social-youtube"></i></a></li>
                                    <li><a href="#."><i class="icon-social-dribbble"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--======= PRODUCT DESCRIPTION =========-->
            <div class="item-decribe">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
            @endif
                <!-- Nav tabs -->
                <ul class="nav nav-pills" role="tablist">
                    <li class="nav-item"> <a class="active nav-link" href="#descr" role="tab" data-toggle="pill">DESCRIPTION</a></li>
                    <li class="nav-item"><a class="nav-link" href="#review" role="tab" data-toggle="pill">REVIEW ({{$product->commentCount()}})</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <!-- DESCRIPTION -->
                    <div role="tabpanel" class="tab-pane active" id="descr">
                    {{$product->meta_description}}
                    </div>

                    <!-- REVIEW -->
                    <div role="tabpanel" class="tab-pane fade" id="review">
                        @if(isset($product->comments))
                            @if(count($product->comments))
                        <h6>{{$product->commentCount()}} REVIEWS FOR SHIP YOUR {{strtoupper($product->title())}}</h6>
                                @else
                                <h6>Be the first to add a review</h6>
                            @endif
                        @endif
                            @if(count($product->comments))
                                @foreach($product->comments as $comment)
                        <!-- REVIEW PEOPLE 1 -->
                        <div class="media">
                            <div class="media-left">
                                <!--  Image -->
                                <div class="avatar"> <a href="#"> <img class="media-object" src="images/avatar-1.jpg" alt=""> </a> </div>
                            </div>
                            <!--  Details -->
                            <div class="media-body">
                                <p>{{$comment->body}}</p>
                                <h6> {{strtoupper($comment->creator->firstname)}} <span class="pull-right">{{$comment->created_at->diffForHumans()}}</span> </h6>
                            </div>
                        </div>
                        @endforeach
                                @endif

                        <!-- ADD REVIEW -->
                        <h6 class="margin-t-40">ADD YOUR REVIEW</h6>
                        <form action="{{route('add_comment', ['product_id' => $product->id])}}" method="post">
                            @csrf
                            <ul class="row">
                                <li class="col-sm-6">
                                    <label> *NAME
                                        @if(Auth::guest())
                                            <input type="text" value="" name="name" placeholder="Guest" disabled>
                                        @else
                                            <input type="text" value="" placeholder="{{Auth::user()->firstname}}" disabled>
                                        @endif
                                    </label>
                                </li>
                                <li class="col-sm-6">
                                    <label> *Subject
                                            <input type="text" value="" name="title">
                                    </label>
                                </li>
                                <li class="col-sm-12">
                                    <label> *YOUR REVIEW
                                        <textarea name="comment"></textarea>
                                    </label>
                                </li>
                                <li class="col-sm-6">
                                    <!-- Rating Stars -->
                                    <span class="rating_indicator off">
                                            <i class="fa fa-circle-o-notch fa-spin processing" aria-hidden="true"></i>
                                            <span> Rating...</span>
                                        </span>
                                    <select class="product-rating-comment" data-slug="{{$product->slug}}">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                    {{--<div class="stars"> <span>YOUR RATING</span> <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>--}}
                                </li>
                                <li class="col-sm-6">
                                    <button type="submit" class="btn btn-dark btn-small pull-right no-margin">POST REVIEW</button>
                                </li>
                            </ul>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

@endsection

@push('script')
    <script src="{{ asset('admin/js/uikit.js') }}" ></script>
    <script src="{{ asset('admin/js/uikit-icons.js') }}" ></script>
    <script>

        $(document).ready(function () {
            var modal = $(".product-to-cart")

            $(".close-modal").click(function(){
                UIkit.modal(modal).hide();
            })

            function validateAddToCart(){
                var status = true;
                $("#product_variants select").map(function (index, item) {

                    if($(item).val() == 'null'){
                        status = false;
                        Snackbar.show({
                            showAction: false,
                            text: 'Please select a ' + $(item).data('option_name'),
                            actionTextColor: '#ffffff',
                            backgroundColor:"#FE970D"
                        });
                    }
                });

                if (status){
                    return true;
                }else{
                    return false;
                }
            }

            function getCustomerVariant(){
                var customer_variants = [];
                $("#product_variants select").map(function (index, item) {
                    var selected_option = $(item).find(":selected");
                    customer_variants.push({
                        option_id:selected_option.data('option_id'),
                        option_name:selected_option.data('option_name'),
                        option_value_id:selected_option.data('option_value_id'),
                        option_value_name:selected_option.data('option_value_name'),
                    })
                })
                return customer_variants;
            }

            $("#add_to_cart").click(function () {
                if ("{!! $product->is_variant !!}" == 1){
                    if (!validateAddToCart()) {
                        return false;
                    }
                }

                $(".processing").removeClass('off')
                $("#add_to_cart").prop('disabled', true)
                var slug = $(this).data('slug');
                var qty = $("input[name='item_qty']").val();
                if(qty < 1){
                    UIkit.alert('Qty less than 1');
                    return false;
                }
                $.ajax({
                    url: "{{route('add_to_cart')}}",
                    type: 'POST',
                    datatype:'json',
                    data: {qty: qty, slug:slug, variant:getCustomerVariant()}
                })
                    .done(function (data) {
                        $(".processing").addClass('off')
                        $("#add_to_cart").prop('disabled', false)
                        $(".c-no").html("<i>"+data.cart_count+"</i>")
                        if(data.cart_count > 1){
                            $(".cart-msg").html("updated in cart")
                        }else{
                            $(".cart-msg").html("added to cart")
                        }
                        UIkit.modal(modal).show();

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

            $('select.product-rating-comment').barrating({
                theme: 'fontawesome-stars',
                onSelect: function(value, text, event) {
                    if (typeof(event) !== 'undefined') {
                        // rating was selected by a user
                        $(".rating_indicator").removeClass('off')
                        var rating = $(event.target).data('rating-value');
                        var slug = $(event.target).parent().prev().data('slug');

                        $.ajax({
                            url: "{{route('rate_product')}}",
                            type: 'POST',
                            data: {rating: rating, slug: slug}
                        })
                            .done(function (data) {
                                $(".rating_indicator").addClass('off')
                                Snackbar.show({
                                    showAction: true,
                                    text: 'Product rated.',
                                    actionTextColor: '#ffffff',
                                    backgroundColor: "#53A6E8"
                                });

                            }).fail(function (error) {
                            $(".rating_indicator").addClass('off')
                            Snackbar.show({
                                showAction: true,
                                text: 'Product rating failed!.',
                                actionTextColor: '#ffffff',
                                backgroundColor: "#FE970D"
                            });
                        })
                    }else {
                        // rating was selected programmatically
                        // by calling `set` method
                    }
                }
            });
            $('select.product-rating-view').barrating({
                theme: 'fontawesome-stars',
                readonly: true
            });
        });
    </script>
@endpush

@push('style')
    <link href="{{ asset('admin/css/uikit.css') }}" rel="stylesheet">
@endpush
