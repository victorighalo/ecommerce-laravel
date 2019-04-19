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
                        <div class="row">

                            <!-- ESTIMATE SHIPPING & TAX -->
                            <div class="col-sm-7">
                                <!-- SHIPPING info -->
                                <h6 class="margin-top-50">Shipping information</h6>
                                <form action="{{url('checkout')}}" method="post">
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
                                                                <option value="{{$state->state_id}}">{{$state->state_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </label>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>City<span>*</span>
                                                        <select name="city_id" id="city" class="form-control" required>
                                                            <option value="" disabled="">Select state</option>
                                                        </select>
                                                    </label>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Email Address<span>*</span>
                                                        <input type="email" name="email" required>
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
                                        @php
                                        $delivery_cost = 0;
                                        @endphp
                                        @foreach(Cart::getItems() as $item)
                                            <p>{{$item->product->name}} <span>&#8358; {{number_format($item->price, '0', '.', ',')}} </span></p>
                                            @php
                                                $delivery_cost += $item->product->delivery_cost;
                                            @endphp
                                        @endforeach
                                            <p>Shipping <span>&#8358; {{$delivery_cost}} </span></p>
                                        <!-- SUB TOTAL -->
                                            <p class="all-total">TOTAL COST <span>&#8358; {{number_format( Cart::total(), '0', '.', ',')}}</span></p>
                                    </div>
                                    <div class="pay-meth">
                                        <ul>
                                            <li>
                                                <div class="radio">
                                                    <input type="radio" name="pay_type" id="radio2" value="option2">
                                                    <label for="radio2"> CASH ON DELIVERY</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="radio">
                                                    <input type="radio" name="pay_type" id="radio4" value="option4">
                                                    <label for="radio4"> DEBIT CART </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="checkbox">
                                                    <input id="checkbox3-4" class="styled" type="checkbox">
                                                    <label for="checkbox3-4"> I’VE READ AND ACCEPT THE <span class="color"> TERMS & CONDITIONS </span> </label>
                                                </div>
                                            </li>
                                        </ul>
                                        <button href="" class="btn btn-small  btn-secondary pull-left margin-top-30" type="button"><i class="fa fa-phone"></i> CALL TO ORDER</button> </div>
                                        <button href="" class="btn  btn-dark pull-right margin-top-30" type="submit"><i class="fa fa-credit-card"></i> PLACE ORDER</button> </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

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