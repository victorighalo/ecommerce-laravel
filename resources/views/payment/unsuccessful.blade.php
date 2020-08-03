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
                    <div class="col-4" style="height: 100px; background: #b35433;">
                        <h4 style="color: #fff;margin-top: 35px;">Transaction Unsuccessful</h4>
                        <h5 style="color: #fff;margin-bottom: 15px;margin-top: -15px; text-align: center; font-size: 20px">{{$message}}</h5>
                    </div>
                    <div class="col-4 text-center p-4">
                        <p>If you have a complaint. Kindly send us a message <a href="{{url('contact')}}" style="color: #1d78cb">here</a> and we will respond appropriately</p>
                    </div>

                </div>
            </div>
        </section>
    </div>

@endsection
