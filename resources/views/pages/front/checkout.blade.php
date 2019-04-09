@extends('layouts.main')
@section('content')
    @include('partials.hero', ['page' => 'Checkout page'])
    <div class="ps-checkout">
        <div class="ps-container">
            @if($cart_count)
                {{--Load address--}}
                @if(count($addresses) > 0)
                    <div style="background-color: #f6f6f6; padding: 15px 12px; margin-bottom: 20px;">
                        <table class="locations">
                            <tbody>
                            @foreach($addresses as $i => $item)
                                <tr class="checkout_address_row">
                                    <td class="left_td">
                                        <input type="radio" name="shipaddress"
                                               value="{{$item->id}}">
                                        <label>
                                            <span class=" d-sm-block pl-4">{{ $item->firstname . " " . $item->lastname }} - {{$item->phone}}</span></label>
                                        <p class="checkout_address d-none d-sm-block">{{$item->address}}
                                            , {{$item->state_name}}
                                            , {{$item->city_name}}</p>
                                    </td>
                                    <td style="text-align: right">
                                        <div class="btn-group">
                                            <button type="button"
                                                    class="btn btn-primary dropdown-toggle"
                                                    data-toggle="dropdown"
                                                    aria-haspopup="true"
                                                    aria-expanded="false">
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item edit-address-btn"
                                                   style="cursor: pointer;"
                                                   id="{{$item->id}}">Edit</a>
                                                <a class="dropdown-item delete-address-btn"
                                                   style="cursor: pointer;"
                                                   id="{{$item->id}}">Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                {{--Add address--}}
            <form class="ps-form--checkout" action="{{url('checkout')}}" method="post">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 ">
                        <div class="ps-checkout__billing">
                            <h3>Delivery Address</h3>
                            <div class="form-group form-group--inline">
                                <label>First Name<span>*</span>
                                </label>
                                <div class="form-group__content">
                                    <input class="form-control" type="text" name="firstname" required>
                                </div>
                            </div>
                            <div class="form-group form-group--inline">
                                <label>Last Name<span>*</span>
                                </label>
                                <div class="form-group__content">
                                    <input class="form-control" name="lastname" type="text">
                                </div>
                            </div>
                            <div class="form-group form-group--inline">
                                <label>State<span>*</span>
                                </label>
                                <div class="form-group__content">
                                    <select name="state_id" id="state" class="form-control" required>
                                    @foreach($states as $state)
                                            <option value="{{$state->state_id}}">{{$state->state_name}}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="form-group form-group--inline">
                                <label>City<span>*</span>
                                </label>
                                <div class="form-group__content">
                                    <select name="city_id" id="city" class="form-control" required>
                                            <option value="" disabled="">Select state</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group form-group--inline">
                                <label>Email Address<span>*</span>
                                </label>
                                <div class="form-group__content">
                                    <input class="form-control" type="email" name="email" required>
                                </div>
                            </div>
                            <div class="form-group form-group--inline">
                                <label>Phone<span>*</span>
                                </label>
                                <div class="form-group__content">
                                    <input class="form-control" type="text" name="phone" required>
                                </div>
                            </div>
                            <div class="form-group form-group--inline">
                                <label>Address<span>*</span>
                                </label>
                                <div class="form-group__content">
                                    <input class="form-control" type="text" name="address" required>
                                </div>
                            </div>

                            <h3 class="mt-40"> Addition information</h3>
                            <div class="form-group form-group--inline textarea">
                                <label>Order Notes</label>
                                <textarea class="form-control" rows="7" placeholder="Notes about your order, e.g. special notes for delivery." name="additional_info"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 ">
                        <div class="ps-checkout__order">
                            <header>
                                <h3>Your Order</h3>
                            </header>
                            <div class="content">
                                <table class="table ps-checkout__products">
                                    <thead>
                                    <tr>
                                        <th class="text-uppercase">Product</th>
                                        <th class="text-uppercase">Subtotal</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($cart))
                                    @if($cart)
                                        @foreach($cart as $cart_item)
                                    <tr>
                                        <td>{{$cart_item->product->name}} x{{$cart_item->quantity}}</td>
                                        <td> <span>&#8358;</span> <span>{{number_format( ($cart_item->price * $cart_item->quantity), '0', '.', ',')}}</span></td>
                                    </tr>
                                    @endforeach
                                        @endif
                                        @endif
                                    </tbody>
                                    <tfoot>
                                    <tr style="color: #fff; font-size: 17px">
                                        <th>Total</th>
                                        <th style="text-align: right">{{number_format( Cart::total(), '0', '.', ',')}}</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <footer>
                                <h3>Payment Method</h3>
                                <div class="form-group cheque">
                                    <div class="ps-radio ps-radio--small">
                                        <input class="form-control" type="radio" id="rdo01" name="payment" checked>
                                        <label for="rdo01">Payment on Delivery</label>
                                    </div>
                                    <p>Please send your cheque to Store Name, Store Street, Store Town, Store State / County, Store Postcode.</p>
                                </div>
                                <div class="form-group paypal">
                                    <div class="ps-radio ps-radio--small">
                                        <input class="form-control" type="radio" name="payment" id="rdo02">
                                        <label for="rdo02">Online</label>
                                    </div>
                                    <ul class="ps-payment-method">
                                        <li><a href="#"><img src="images/payment/1.png" alt=""></a></li>
                                        <li><a href="#"><img src="images/payment/2.png" alt=""></a></li>
                                        <li><a href="#"><img src="images/payment/3.png" alt=""></a></li>
                                    </ul>
                                    <button class="ps-btn ps-btn--fullwidth" type="submit">Place Order</button>
                                </div>
                            </footer>
                        </div>
                    </div>
                </div>
            </form>
                @else
                <h3>Sorry, your shopping Cart is empty</h3>
                @endif
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function () {
        $("select[name='state_id']").on('change', function () {
            stateid = $(this).val();
            $("select[name='city_id']").empty();
            $("select[name='city_id']").append('<option>Loading...</option>');
            $("select[name='city_id']").prop('disabled', true);
            $.post("{!! url('load_cities') !!}",{id: stateid})
                .done(function(msg) {
                    $("select[name='city_id']").empty();
                    $("select[name='city_id']").prop('disabled', false);
                    $.each(msg, function (key, value) {
                        $("select[name='city_id']").append('<option value="' + value.city_id + '">' + value.city_name + '</option>');
                    });
                })
        });

        });
    </script>
    @endpush