@extends('layouts.newmain')

@section('content')

    <div id="content">

        <!-- PAGES INNER -->
        <section class="chart-page login gray-bg padding-top-100 padding-bottom-100">
            <div class="container">

                <!-- Payments Steps -->
                <div class="shopping-cart">

                    <!-- SHOPPING INFORMATION -->
                    <div class="cart-ship-info">
                        <div class="row">

                            <!-- Login Register -->
                            <div class="col-sm-7 center-block">
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                <h3 class="text-center margin-40">{{ __('Reset Password') }}</h3>

                                <!-- Login -->
                                <form method="POST" action="{{ route('password.update') }}">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <ul class="row">
                                        <!-- Email -->
                                        <li class="col-md-12">
                                            <label> {{ __('E-Mail Address') }}
                                                <input id="email" type="email"
                                                       class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                       name="email" value="{{ old('email') }}" required autofocus
                                                       class="form-control">
                                            </label>
                                            @if ($errors->has('email'))
                                                <span role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                            @endif
                                        </li>

                                        <li class="col-md-12">
                                            <label> Password
                                                <input id="password" type="password"
                                                       class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                                       name="password" required class="form-control">
                                            </label>
                                            @if ($errors->has('password'))
                                                <span role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                            @endif
                                        </li>

                                        <!-- Password -->
                                        <li class="col-md-12">
                                            <label> Password
                                                <input id="password-confirmation" type="password"
                                                       class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                                                       name="password_confirmation" required class="form-control">
                                            </label>
                                        </li>

                                        <!-- LOGIN -->
                                        <li class="col-md-6">
                                            <button type="submit" class="btn">  {{ __('Send Password Reset Link') }}</button>
                                        </li>


                                    </ul>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection