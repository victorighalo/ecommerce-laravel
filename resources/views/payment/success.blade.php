@extends('layouts.newmain')

@section('content')

    <!--======= SUB BANNER =========-->
    @include('partials.frontend.sub_banner', ['title' => 'Transaction report'])
    <!-- Content -->
    <div id="content">

        <!-- History -->
        <section class="history-block padding-top-100 padding-bottom-100">
            <div class="container">
                <div class="d-flex justify-content-center flex-column align-items-center">
                <div class="col-4" style="height: 100px; background: #54b342;">
                  <h4 style="color: #fff;margin-top: 35px;">Transaction Successful</h4>
                </div>
                    <div class="col-4 text-left p-4">
                        <h4 class="text-left">Transaction ID : <span>{{$ref}}</span></h4>
                        <div>
                          <h5>The delivery will be made to :</h5>
                          <p>Firstname : <span>{{$trans->firstname}}</span></p>
                          <p>Lastname : <span>{{$trans->lastname}}</span></p>
                          <p>Phone : <span>{{$trans->phone}}</span></p>
                          <p>Email : <span>{{$trans->user_email}}</span></p>
                          <p>State : <span>{{$trans->state->state_name}}</span></p>
                          <p>City : <span>{{$trans->city->city_name}}</span></p>
                          <p>Address : <span>{{$trans->address}}</span></p>
                        </div>
                    </div>

                    <div class="col-8">
                        <h6>Products Ordered</h6>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($cart_with_variants))
                            @foreach($cart_with_variants as $item)
                                <tr>
                                    <td>
                                        <span>{{$item->product->name}}</span>
                                        @if($item->product->is_variant)
                                            @if(isset($item->variants))
                                                @foreach($item->variants as $variant)
                                                    <small class="font-weight-bold">{{$variant->option_name}}:</small> <small>{{$variant->option_value_name}}</small>
                                                @endforeach
                                            @endif
                                        @endif
                                    </td>
                                    <td>{{$item->quantity}}</td>
                                    <td>&#8358;{{number_format($item->price, 0, '.', ',')}}</td>
                                    <td>&#8358;{{number_format($item->price * $item->quantity, 0, '.', ',')}}</td>
                                </tr>
                            @endforeach
                                @endif
                            </tbody>
                            <tfoot>
{{--                                <tr>--}}
{{--                                    <th>--}}
{{--                                         Shipping cost--}}
{{--                                    </th>--}}
{{--                                    <th>--}}
{{--                                        {{number_format($trans->amount, 0, '.', ',')}}--}}
{{--                                    </th> --}}
{{--                                <tr>--}}
                                    <th class="p-2">
                                        Total cost (including shipping)
                                    </th>
                                    <th colspan="3" class="text-center">
                                        &#8358;{{number_format($trans->amount, 0, '.', ',')}}
                                    </th>
                                </tr>
                            </tfoot>
                        </table>

                    </div>

                </div>
            </div>
        </section>
    </div>

@endsection
