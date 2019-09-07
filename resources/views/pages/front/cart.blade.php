@extends('layouts.newmain')

@section('content')

    <!--======= SUB BANNER =========-->
    @include('partials.frontend.sub_banner', ['title' => 'Cart'])
    <div id="content">

    @if(count($cart))
        <!-- PAGES INNER -->
        <section class="padding-top-100 padding-bottom-100 pages-in chart-page">
            <div class="container">

                <!-- Payments Steps -->
                <div class="shopping-cart text-center">
                    <table class="table">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col" class="text-left">Items</th>
                            <th scope="col">Price</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Total</th>
                            <th scope="col">&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cart as $item)
                        <tr>
                            <th class="text-left"> <!-- Media Image -->
                                <a href="#." class="item-img">
                                    @if($item->product->hasPhoto())
                                    <img class="media-object" src="{{$item->product->FirstImage}}" alt="">
                                    @endif
                                </a>
                                <!-- Item Name -->
                                <div class="media-body">
                                    <span>{{$item->product->name}}</span>
                                </div>
                            </th>
                            <td><span class="price"> <small>&#8358;</small> {{number_format($item->price, '0', '.', ',')}}</span></td>
                            <td>
                                <div class="quantity">
                                    <input type="number" min="1" max="100" step="1" value="{{$item->quantity}}" class="form-control qty" data-cart_id="{{$item->id}}">
                                </div>
                            </td>
                            <td><span class="price"> <small>&#8358;</small> {{number_format( ($item->price * $item->quantity), '0', '.', ',')}}</span></td>
                            <td><a href="#." data-cart_id="{{$item->id}}" class="destroy"><i class="icon-close"></i></a></td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        @else
            <div class="alert alert-info">
                <div class="container">
                    <div class="alert-icon">
                        <i class="fa fa-exclamation-circle"></i>
                    </div>
                    <h5>Your cart is empty</h5>
                </div>
            </div>
        @endif

        <!-- PAGES INNER -->
        @if(count($cart))
        <section class="padding-top-100 padding-bottom-100 light-gray-bg shopping-cart small-cart">
            <div class="container">

                <!-- SHOPPING INFORMATION -->
                <div class="cart-ship-info margin-top-0">
                    <div class="row">

                        <!-- DISCOUNT CODE -->
                        <div class="col-sm-7">
                            {{--<h6>Discound Code</h6>--}}
                            {{--<form>--}}
                                {{--<input type="text" value="" placeholder="ENTER YOUR CODE IF YOU HAVE ONE">--}}
                                {{--<button type="submit" class="btn btn-small btn-dark">APPLY CODE</button>--}}
                            {{--</form>--}}
                            <div class="coupn-btn"> <a href="{{url('/')}}" class="btn">continue shopping</a></div>
                        </div>

                        <!-- SUB TOTAL -->
                        <div class="col-sm-5">
                            <h6>Checkout</h6>
                            <div class="grand-total">
                                <div class="order-detail">
                                    @foreach($cart as $item)
                                    <p>{{$item->product->name}} <span>&#8358; {{number_format($item->price, '0', '.', ',')}} </span></p>
                                    @endforeach

                                    <!-- SUB TOTAL -->
                                    <p class="all-total">TOTAL COST <span>&#8358; {{number_format( Cart::total(), '0', '.', ',')}}</span></p>
                                </div>
                                <a href="{{url('checkout')}}" class="btn margin-top-20">Proceed to checkout</a> </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
            @endif
    </div>
    @endsection
@push('script')
    <script src="{{ asset('assets/js/lodash.min.js')}}"></script>
    <script>

        $(document).ready(function () {

            var update = function() {
                var cart_id = $(this).data('cart_id');
                $.post('{!! route('update_cart') !!}'+'/'+cart_id, {
                    qty: $(this).val(),
                    "_token": "{{ csrf_token() }}",
                })
                    .done(function (data) {
                        Snackbar.show({
                            showAction: true,
                            text: 'Cart updated.',
                            actionTextColor: '#ffffff',
                            backgroundColor:"#53A6E8",
                            actionText: 'Close!',
                            pos: 'top-right'
                        });
                        setTimeout(function () {
                            location.reload()
                        }, 2000);
                    })
                    .fail(function (error) {
                        Snackbar.show({
                            showAction: true,
                            text: 'Cart update failed!.',
                            actionTextColor: '#ffffff',
                            backgroundColor:"#FE970D",
                            actionText: 'Close!',
                            pos: 'top-right'
                        });
                    })
            };

            var destroy = function() {
                Snackbar.show({
                    showAction: true,
                    text: 'Removing item from cart',
                    actionTextColor: '#ffffff',
                    backgroundColor:"#53A6E8",
                    actionText: 'Close!',
                    pos: 'top-right'
                });
                var cart_id = $(this).data('cart_id');
                var self = $(this)
                $.post('{!! route('destroy_cart') !!}'+'/'+cart_id)
                    .done(function (data) {
                        Snackbar.show({
                            showAction: true,
                            text: data,
                            actionTextColor: '#ffffff',
                            backgroundColor:"rgb(65,98,187)",
                            actionText: 'Close!',
                            pos: 'top-right'
                        });
                        self.parent().parent().fadeOut()
                    })
                    .fail(function (error) {
                        Snackbar.show({
                            showAction: true,
                            text: 'Cart item delete failed!.',
                            actionTextColor: '#ffffff',
                            backgroundColor:"#FE970D",
                            actionText: 'Close!',
                            pos: 'top-right'
                        });
                    })
            };

            $(".qty").on({
                change: _.debounce(update, 500)
            });

            $(".destroy").on({
                click: _.debounce(destroy, 500)
            });

        });

    </script>
@endpush
