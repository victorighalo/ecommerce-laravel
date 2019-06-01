@extends('layouts.newmain')

@section('content')

    <!--======= SUB BANNER =========-->
    @include('partials.frontend.sub_banner', ['title' => 'Change Password'])
    <!-- Content -->
    <div id="content">
        <!-- History -->
        <section class="history-block padding-top-100 padding-bottom-10">
            <div class="container">
                <div class="about-us-con">

                    <section class="contact padding-top-10 padding-bottom-100">

<div class="container">
    <div class="contact-form">
        <div class="row margin-top-30">
            <div class="col-md-6">
                @if (session('status'))
                    <div id="contact_message" class="success-msg on">
                        <i class="fa fa-paper-plane-o"></i>
                        {{ session('status') }}
                    </div>
                @endif

                <h5>Password <p>change your password</p></h5>
                    @if ($errors->has('password'))
                        <div class="margin-bottom-20">
                        <span role="alert" class="alert-danger">
                         <strong>{{ $errors->first('password') }}</strong>
                          </span>
                        </div>
                    @endif
                <form role="form" id="password_form" action="{{url('change_password')}}"
                      class="contact-form" method="post">
                    @csrf
                    <ul class="row">
                        <li class="col-sm-6">
                            <label>password *
                                <input type="password" class="form-control" name="password"
                                       id="password"
                                       placeholder="">
                            </label>

                        </li>
                        <li class="col-sm-6">
                            <label>confirm password *
                                <input type="password" class="form-control" name="password_confirmation"
                                       id="password_confirmation"
                                >
                            </label>
                        </li>


                        <li class="col-sm-12">
                            <button type="submit" value="submit" class="btn" id="btn_submit"
                                    onClick="proceed();">UPDATE
                            </button>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
</div>

                    </section>
                </div>
            </div>
        </section>
    </div>
    {{--Product request--}}
    @include('partials.frontend.product_request')
@endsection