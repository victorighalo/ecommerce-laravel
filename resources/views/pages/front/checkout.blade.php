@extends('layouts.newmain')

@section('content')

    <!--======= SUB BANNER =========-->
    @include('partials.frontend.sub_banner', ['title' => 'Checkout'])
    <!-- Content -->
    <div id="content">

        <!--======= PAGES INNER =========-->
        <section class="chart-page padding-top-100 padding-bottom-100">
            <div class="container">

                <!-- Payments Steps -->
                <div class="shopping-cart">
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
                    </div>
                    <!-- SHOPPING INFORMATION -->
                    <div class="cart-ship-info">
                            <form action="{{url('checkout')}}" method="post" class="row">
                            <div class="col-sm-7">
                                <!-- SHIPPING info -->
                                <h6 class="margin-top-50">Shipping information</h6>
                                    {{ csrf_field() }}
                                    <div class="row">
                                                <div class="col-md-6">
                                                    <label>First Name<span>*</span>
                                                        <input type="text" name="firstname" required>
                                                    </label>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Last Name<span>*</span>
                                                        <input name="lastname" type="text">
                                                    </label>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>State<span>*</span>
                                                        <select name="state_id" id="state" class="form-control" required>
                                                            @foreach($states as $state)
                                                                @if($state->state_id == 7)
                                                                <option value="{{$state->state_id}}" selected>{{$state->state_name}}</option>
                                                                @else
                                                                    <option value="{{$state->state_id}}">{{$state->state_name}}</option>
                                                                @endif
                                                                    @endforeach
                                                        </select>
                                                    </label>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>City<span>*</span>
                                                        <select name="city_id" id="city" class="form-control" data-city_id="" required>
                                                            <option value="" disabled="">Select state</option>
                                                        </select>
                                                    </label>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Email Address<span>*</span>
                                                        <input type="email" name="email" value="{{Auth::guest() ? '' : Auth::user()->email}}" required {{Auth::guest() ? '' : 'disabled'}}>
{{--                                                        <input type="email" name="email">--}}
                                                    </label>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Phone<span>*</span>
                                                        <input type="text" name="phone" required>
                                                    </label>
                                                </div>
                                                <div class="col-md-12">
                                                    <label>Address<span>*</span>
                                                        <input type="text" name="address" required>
                                                    </label>
                                                </div>

                                                <div class="col-md-12">
                                                    <label>Order Notes</label>
                                                    <textarea class="form-control" rows="7" placeholder="Notes about your order, e.g. special notes for delivery." name="additional_info"></textarea>
                                                    </div>
                                    </div>

                            </div>
                            <!-- SUB TOTAL -->
                            <div class="col-sm-5">
                                <h6>Your Order</h6>
                                <div class="order-place">
                                    <div class="order-detail">
                                        @foreach(Cart::getItems() as $item)
{{--                                            <pre>@php(var_dump($item))</pre>--}}
                                            <p>{{$item->product->name}} ({{$item->quantity}}) <span>&#8358; {{number_format($item->price, '0', '.', ',')}} </span></p>
                                        @endforeach
                                            <p>Shipping <span class="delivery_cost" data-delivery_cost="{{$delivery_cost}}">{{number_format( $delivery_cost, '0', '.', ',')}}</span><span>&#8358;</span></p>
                                        <!-- SUB TOTAL -->
                                            <p class="all-total">TOTAL COST <span class="total_cost" data-total_cost="{{$total_cost}}">{{number_format( $total_cost, '0', '.', ',')}}</span><span>&#8358;</span></p>
                                    </div>
                                    <div class="loader off"></div>
                                    @if (Cart::isNotEmpty())
                                    <div class="pay-meth">
                                        <ul>
                                            <li>
                                                <div class="checkbox">
                                                    <input type="checkbox" name="cash_on_delivery" id="checkbox" value="option2">
                                                    <label for="checkbox"> CASH ON DELIVERY</label>
                                                </div>
                                            </li>
{{--                                            <li>--}}
{{--                                                <div class="radio">--}}
{{--                                                    <input type="radio" name="pay_type" id="radio4" value="option4">--}}
{{--                                                    <label for="radio4"> DEBIT CART </label>--}}
{{--                                                </div>--}}
{{--                                            </li>--}}
{{--                                            <li>--}}
{{--                                                <div class="checkbox">--}}
{{--                                                    <input id="checkbox3-4" class="styled" type="checkbox">--}}
{{--                                                    <label for="checkbox3-4"> I’VE READ AND ACCEPT THE <span class="color"> TERMS & CONDITIONS </span> </label>--}}
{{--                                                </div>--}}
{{--                                            </li>--}}
                                        </ul>
                                        <a href="tel:{{$app_settings->store_phone}}" class="btn btn-small  btn-secondary pull-left margin-top-30"><i class="fa fa-phone"></i> CALL TO ORDER</a>
                                        </div>
                                        <button href="" class="btn  btn-dark pull-right margin-top-30 checkout" type="submit"><i class="fa fa-credit-card"></i> PLACE ORDER</button> </div>
                                        </div>
                                        @endif

                                    </form>
                            </div>
                        </div>
    </div>

        </section>

    </div>
    @endsection

@push('script')
{{--    <script src="http://checkout.seerbitapi.com/api/v1/seerbit.js"></script>--}}
{{--    <script src="http://rubic.surge.sh/api/v1/seerbit.js"></script>--}}
{{--<script src="https://js.paystack.co/v1/inline.js"></script>--}}

    <script>
        $(document).ready(function () {
            // function payWithPaystack() {
            //     var handler = PaystackPop.setup({
            //         key: 'pk_test_70dc658579b41803bb95c3a8552253f4ca1bd9dc',
            //         email: 'victorighalo@gmail.com',
            //         amount: 10000,
            //         currency: "NGN",
            //         ref: '' + Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
            //         metadata: {
            //             custom_fields: [
            //                 {
            //                     display_name: "Mobile Number",
            //                     variable_name: "mobile_number",
            //                     value: "+2348012345678"
            //                 }
            //             ]
            //         },
            //         callback: function (response) {
            //             alert('success. transaction ref is ' + response.reference);
            //         },
            //         onClose: function () {
            //             alert('window closed');
            //         }
            //     });
            //     handler.openIframe();
            // }
            // payWithPaystack()
            // try {
            //     SeerbitPay({
            //         "tranref": new Date().getTime(),
            //         "currency": "NGN",
            //         "description": "Transaction from BigStanAutos",
            //         "country": "NG",
            //         "amount": 6000,
            //         "full_name": "Victor Ighalo",
            //         "email": "victorighalo@gmail.com",
            //         // "callbackurl": "",
            //         "public_key": "tNUFstIHrE", //replace this with your own public key
            //     }, callback = (response) => {
            //         console.log(response) /*response of transaction*/
            //     }, close = (close) => {
            //         console.log(close) /*transaction close*/
            //     })()
            // }catch (e) {
            //     console.log(e)
            //     Snackbar.show({
            //         showAction: false,
            //         text: "An Error Occurred processing your request",
            //         actionTextColor: '#ffffff',
            //         backgroundColor:"rgb(65,98,187)",
            //         actionText: 'Close!',
            //         pos: 'top-right'
            //     });
            // }
            $("select[name='state_id']").on('change', function () {
                loadCities($(this).val())
            } );

            $("select[name='city_id']").on('change', function () {
                getDeliveryCost();
            } );

            loadCities($("select[name='state_id']").val())


        });


        function loadCities(stateid) {
            $("select[name='city_id']").empty();
            $("select[name='city_id']").append('<option>Loading...</option>');
            $("select[name='city_id']").prop('disabled', true);
            $.post("{!! url('load_cities') !!}",{id: stateid})
                .done(function(msg) {
                    $("select[name='city_id']").empty();
                    $("select[name='city_id']").prop('disabled', false);
                    $.each(msg, function (key, value) {
                        $("select[name='city_id']").append('<option value="' + value.city_id + '" data-city_id="' + value.city_id +'">' + value.city_name + '</option>');
                    });
                    getDeliveryCost();
                })
        }

        function getDeliveryCost() {
            $("button.checkout").attr("disabled", true);
            $(".loader").removeClass("off");
            $.post("{!! url('get_delivery_cost') !!}",
                {
                    state_id: $("select[name='state_id']").val(),
                    city_id: $("select[name='city_id']").children("option:selected").data('city_id'),
                }
                )
                .done(function(res) {
                    if (res.total_cost > 0){
                        $("button.checkout").attr("disabled", false);
                    }else{
                        Snackbar.show({
                            showAction: false,
                            text: "Your cart is empty",
                            actionTextColor: '#ffffff',
                            backgroundColor:"rgb(65,98,187)",
                            actionText: 'Close!',
                            pos: 'top-right'
                        });
                    }
                    $(".loader").addClass("off");
                    var delivery_cost = new Intl.NumberFormat('en-GB').format(Math.ceil(res.delivery_cost));
                    var total_cost = new Intl.NumberFormat('en-GB').format(Math.ceil(res.total_cost));

                    $(".delivery_cost").html(delivery_cost)
                    $(".total_cost").html(total_cost)
                })
                .fail(function (res) {
                    $("button.checkout").attr("disabled", false);
                    $(".loader").addClass("off");
                })
        }
    </script>
@endpush
