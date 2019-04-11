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
                                <h3 class="text-center margin-40">Login</h3>

                                <!-- Login -->
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
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
                                        <!-- Password -->
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

                                        <!-- LOGIN -->
                                        <li class="col-md-6">
                                            <button type="submit" class="btn">LOGIN</button>
                                        </li>

                                        <!-- FORGET PASS -->
                                        <li class="col-md-6">
                                            <div class="margin-top-15 text-right">
                                                @if (Route::has('password.request'))
                                                    <a  href="{{ route('password.request') }}">
                                                        {{ __('Forgot Your Password?') }}
                                                    </a>
                                                @endif
                                            </div>
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