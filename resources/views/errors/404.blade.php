@extends('layouts.newmain')

@section('content')
    <!-- Content -->
    <div id="content">
        <!-- History -->
        <section class="history-block padding-top-100 padding-bottom-100">
            <div class="container">
                <div class="about-us-con text-center">
                    <h1>404 <span> Page not found</span></h1>
            <p>We are looking for your page … but we can’t find it</p><a class="ps-btn " href="{{url('/')}}">Find your way Back Home <i class="fa fa-home"></i></a><br>
                    <img src="{{asset('assets/images/404-error.svg')}}" style="width: 20%; margin-top: 30px" alt="">
        </div>
    </div>
        </section>
    </div>
@endsection