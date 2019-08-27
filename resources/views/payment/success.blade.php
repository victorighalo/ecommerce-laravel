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
                    <div class="col-4 text-center p-4">
                        <h4>Transaction ID : <span>{{$ref}}</span></h4>
                        <div>
                          <h4>The delivered will be made to :</h4>
                          <p>Firstname : <span>{{$trans->firstname}}</span></p>
                          <p>Lastname : <span>{{$trans->lastname}}</span></p>
                          <p>Phone : <span>{{$trans->phone}}</span></p>
                          <p>Email : <span>{{$trans->user_email}}</span></p>
                        </div>
                    </div>

                    <div class="col-8">
                        <h6>Products Ordered</h6>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Price</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $item)
                                <tr>
                                    <td>{{$item->name}}</td>
                                    <td>&#8358;{{number_format($item->price, 0, '.', ',')}}</td>
                                </tr>
                            @endforeach
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
                                    <th>
                                        Total cost (including shipping)
                                    </th>
                                    <th>
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
