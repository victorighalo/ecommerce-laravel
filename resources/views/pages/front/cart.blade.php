@extends('layouts.main')

@section('content')
    @include('partials.hero')
    <div class="ps-content">
        <div class="ps-container">
            <div class="ps-cart-listing">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                    @if (session('error'))
                        <div class="alert alert-success">
                            {{ session('error') }}
                        </div>
                    @endif
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
                                <input class="form-control" type="text" value="{{$item->quantity}}">
                                <button class="plus"><span>+</span></button>
                            </div>
                        </td>
                        <td>
                            <span>&#8358;</span> {{number_format( ($item->price * $item->quantity), '0', '.', ',')}}
                        </td>
                        <td>
                            <a href="{{route('destroy_item_cart', ['slug' => $item->product->slug])}}"> <div class="ps-remove"></div></a>
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
                        <h3>Total Price:  <span>&#8358;</span> {{number_format( ($item->total()), '0', '.', ',')}}</h3><a class="ps-btn" href="checkout.html">Process to checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>

        $(document).ready(function () {
            var searchRequest = null;
            var searchInput = $("#search-input");

            var searchEvents = function() {
                if (searchRequest)
                    searchRequest.abort()
                searchRequest = $.get('/search', {term: $(this).val()}, null, 'script');
            };

            searchInput.on({
                change: searchEvents,
                keyup: $.debounce(500, searchEvents)
            });
        });

    </script>
@endpush