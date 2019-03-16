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
            <form class="ps-form--checkout" action="{{url('add_address')}}" method="post">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 ">
                        <div class="ps-checkout__billing">
                            <h3>Billing Details</h3>
                            <div class="form-group form-group--inline">
                                <label>First Name<span>*</span>
                                </label>
                                <div class="form-group__content">
                                    <input class="form-control" type="text" required>
                                </div>
                            </div>
                            <div class="form-group form-group--inline">
                                <label>Last Name<span>*</span>
                                </label>
                                <div class="form-group__content">
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <div class="form-group form-group--inline">
                                <label>State<span>*</span>
                                </label>
                                <div class="form-group__content">
                                    <select name="state" id="state" class="form-control" required>
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
                                    <select name="city" id="city" class="form-control" required>
                                            <option value="" disabled="">Select state</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group form-group--inline">
                                <label>Email Address<span>*</span>
                                </label>
                                <div class="form-group__content">
                                    <input class="form-control" type="email" required>
                                </div>
                            </div>
                            <div class="form-group form-group--inline">
                                <label>Phone<span>*</span>
                                </label>
                                <div class="form-group__content">
                                    <input class="form-control" type="text" required>
                                </div>
                            </div>
                            <div class="form-group form-group--inline">
                                <label>Address<span>*</span>
                                </label>
                                <div class="form-group__content">
                                    <input class="form-control" type="text" required>
                                </div>
                            </div>
                            <div class="form-group form-group--inline">
                            <button class="ps-btn ps-btn--sm">Add  delivery address</button>
                            </div>
                            <div class="form-group">
                                <div class="ps-checkbox">
                                    <input class="form-control" type="checkbox" id="cb01">
                                    <label for="cb01">Create an account?</label>
                                </div>
                            </div>
                            <h3 class="mt-40"> Addition information</h3>
                            <div class="form-group form-group--inline textarea">
                                <label>Order Notes</label>
                                <textarea class="form-control" rows="7" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
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
                                        <th class="text-uppercase">Total</th>
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
                                    <button class="ps-btn ps-btn--fullwidth">Place Order</button>
                                </div>
                            </footer>
                        </div>
                        <div class="ps-shipping">
                            <h3>FREE SHIPPING</h3>
                            <p>YOUR ORDER QUALIFIES FOR FREE SHIPPING.<br> <a href="#"> Singup </a> for free shipping on every order, every time.</p>
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
        $("select[name='state']").on('change', function () {
            stateid = $(this).val();
            $("select[name='city']").empty();
            $("select[name='city']").append('<option>Loading...</option>');
            $("select[name='city']").prop('disabled', true);
            $.post("{!! url('load_cities') !!}",{id: stateid})
                .done(function(msg) {
                    $("select[name='city']").empty();
                    $("select[name='city']").prop('disabled', false);
                    $.each(msg, function (key, value) {
                        $("select[name='city']").append('<option value="' + value.city_id + '">' + value.city_name + '</option>');
                    });
                })
        });

        });
    </script>
    @endpush