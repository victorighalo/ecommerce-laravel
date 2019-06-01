@extends('layouts.newmain')

@section('content')

    <!--======= SUB BANNER =========-->
    @include('partials.frontend.sub_banner', ['title' => 'Profile'])
    <!-- Content -->
    <div id="content">
        <!-- History -->
        <section class="history-block padding-top-100 padding-bottom-50">
            <div class="container">
                <div class="about-us-con">

                        <section class="contact padding-top-10 padding-bottom-100">
                            <div class="container">
                                <div class="contact-form">
                                    <div class="row">
                                        <div class="col-md-6">
                                            @if (session('status'))
                                                <div id="contact_message" class="success-msg on">
                                                    <i class="fa fa-paper-plane-o"></i>
                                                    {{ session('status') }}
                                                </div>
                                            @endif
                                            <h5>Profile <p>View and update your profile</p></h5>
                                            <form role="form" id="contact_form" action="{{url('profile')}}"
                                                  class="contact-form" method="post">
                                                @csrf
                                                <ul class="row">
                                                    <li class="col-sm-6">
                                                        <label>first name *
                                                            <input type="text" class="form-control" name="firstname"
                                                                   id="name" value="{{Auth::user()->firstname}}"
                                                                   placeholder="">
                                                        </label>
                                                        @if ($errors->has('firstname'))
                                                            <span role="alert">
                                                        <strong>{{ $errors->first('firstname') }}</strong>
                                                        </span>
                                                            @endif
                                                    </li>
                                                    <li class="col-sm-6">
                                                        <label>last name *
                                                            <input type="text" class="form-control" name="lastname"
                                                                   id="name" value="{{Auth::user()->lastname}}"
                                                                   placeholder="">
                                                        </label>
                                                        @if ($errors->has('lastname'))
                                                            <span role="alert">
                                                         <strong>{{ $errors->first('lastname') }}</strong>
                                                            </span>
                                                        @endif
                                                    </li>
                                                    <li class="col-sm-6">
                                                        <label>Email *
                                                            <input type="text" class="form-control" name="email"
                                                                   id="email" value="{{Auth::user()->email}}"
                                                                   placeholder="" disabled="disabled">
                                                        </label>
                                                    </li>

                                                    <li class="col-sm-12">
                                                        <button type="submit" value="submit" class="btn" id="btn_submit"
                                                                onClick="proceed();">UPDATE
                                                        </button>
                                                    </li>
                                                </ul>
                                            </form>
                                                <a href="{{url('change_password')}}" class="btn btn-inverse-teal"><span class="fa fa-lock"></span> Change Password</a>
                                        </div>
                                        </div>
                                </div>
                            </div>
                        </section>
                </div>
            </div>
        </section>
        {{--Product request--}}
        @include('partials.frontend.product_request')

    </div>

@endsection