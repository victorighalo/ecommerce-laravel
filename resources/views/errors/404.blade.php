@extends('layouts.main')

@section('content')
    <div class="ps-404">
        <div class="container">
            <h1>404 <span> Page not found</h1>
            <p>We are looking for your page … but we can’t find it</p><a class="ps-btn" href="{{url('/')}}">Back to Home</a><br><img src="images/404.png" alt="">
        </div>
    </div>
@endsection