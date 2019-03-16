@extends('layouts.main')

@section('content')
    @include('partials.hero', ['page' => 'Cart page'])
    <div class="ps-content">
        <div class="ps-container">
            <div class="ps-cart-listing">
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

                    @if(count($cart))
                <table class="table ps-cart__table">
                    <thead>
                    <tr>
                        <th>All Products</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cart as $item)
                    <tr>
                        <td><a class="ps-product--compare" href="product-detail.html">
                                <img class="mr-15" src="{{$item->product->getMedia('images')->first()->getFullUrl()}}" alt="">
                                {{$item->product->name}}</a></td>
                        <td>
                            <span>&#8358;</span> {{number_format($item->price, '0', '.', ',')}}
                         </td>
                        <td>
                            <div class="form-group--number">
                                <button class="minus"><span>-</span></button>
                                <input class="form-control" type="text" value="{{$item->quantity}}" data-cart_id="{{$item->id}}">
                                <button class="plus"><span>+</span></button>
                            </div>
                        </td>
                        <td>
                            <span>&#8358;</span> {{number_format( ($item->price * $item->quantity), '0', '.', ',')}}
                        </td>
                        <td>
                            <div data-cart_id="{{$item->id}}" class="ps-remove destroy"></div>
                        </td>
                    </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="ps-cart__actions">
                    <div class="ps-cart__promotion">
                        <div class="form-group">
                            <div class="ps-form--icon"><i class="fa fa-angle-right"></i>
                                <input class="form-control" type="text" placeholder="Promo Code">
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="ps-btn ps-btn--gray">Continue Shopping</button>
                        </div>
                    </div>
                    <div class="">
                        <h3>Total Price:  <span>&#8358;</span> {{number_format( ($item->total()), '0', '.', ',')}}</h3><a class="ps-btn" href="{{url('checkout')}}">Process to checkout</a>
                    </div>
                </div>
                        @else
                        <div class="alert alert-info text-center">
                            Cart is empty
                        </div>
                        @endif
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>

        $(document).ready(function () {

            var minus = function() {
                var cart_id = $(this).next().data('cart_id');
                $.post('{!! route('update_cart') !!}'+'/'+cart_id, {qty: $(this).next().val()})
                    .done(function (data) {
                        Snackbar.show({
                            showAction: true,
                            text: 'Cart updated.',
                            actionTextColor: '#ffffff',
                            backgroundColor:"#53A6E8",
                            actionText: 'Close!'
                        });
                    })
                    .fail(function (error) {
                        Snackbar.show({
                            showAction: true,
                            text: 'Cart update failed!.',
                            actionTextColor: '#ffffff',
                            backgroundColor:"#FE970D",
                            actionText: 'Close!'
                        });
                    })
            };
            var plus = function() {
                var cart_id = $(this).prev().data('cart_id');
                $.post('{!! route('update_cart') !!}'+'/'+cart_id, { qty: $(this).prev().val()})
                    .done(function (data) {
                        Snackbar.show({
                            showAction: true,
                            text: 'Cart updated.',
                            actionTextColor: '#ffffff',
                            backgroundColor:"#53A6E8",
                            actionText: 'Close!'
                        });
                    })
                    .fail(function (error) {
                        Snackbar.show({
                            showAction: true,
                            text: 'Cart update failed!.',
                            actionTextColor: '#ffffff',
                            backgroundColor:"#FE970D",
                            actionText: 'Close!'
                        });
                    })
            };

            var destroy = function() {
                Snackbar.show({
                    showAction: true,
                    text: 'Removing item from cart',
                    actionTextColor: '#ffffff',
                    backgroundColor:"#53A6E8",
                    actionText: 'Close!'
                });
                var cart_id = $(this).data('cart_id');
                var self = $(this)
                $.post('{!! route('destroy_cart') !!}'+'/'+cart_id)
                    .done(function (data) {
                        Snackbar.show({
                            showAction: true,
                            text: data,
                            actionTextColor: '#ffffff',
                            backgroundColor:"#53A6E8",
                            actionText: 'Close!'
                        });
                        self.parent().parent().fadeOut()
                    })
                    .fail(function (error) {
                        Snackbar.show({
                            showAction: true,
                            text: 'Cart item delete failed!.',
                            actionTextColor: '#ffffff',
                            backgroundColor:"#FE970D",
                            actionText: 'Close!'
                        });
                    })
            };

            $(".minus").on({
                click: _.debounce(minus, 500)
            });

            $(".plus").on({
                click: _.debounce(plus, 500)
            });

            $(".destroy").on({
                click: _.debounce(destroy, 500)
            });
        });

    </script>
@endpush