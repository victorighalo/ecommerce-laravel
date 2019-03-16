<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="apple-touch-icon.png" rel="apple-touch-icon">
    <link href="favicon.png" rel="icon">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

<!-- Fonts -->
    <link rel="stylesheet" href="{{asset('plugins/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">

</head>
<body>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row justify-content-center flex-grow mb-5 mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-sm-6 p-4 mb-5">
                                <h4 class="card-title font-weight-bold"> App Settings
                                </h4>
                                <div>
                                    @if (session('status'))
                                        <div class="alert alert-success">
                                            {{ session('status') }}
                                        </div>
                                    @endif
                                    @if (session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    <form id="product_form" action="{{url('install')}}" method="post">
                                        @csrf
                                        {{ method_field('POST') }}
                                        <div class="row form-group">
                                            <div class="col-sm-12 mb-3">
                                                <label for="name">{{ __('App name') }} <sup>*</sup></label>
                                                <input type="text" id="name" class="form-control" name="store_name" required>
                                                <span class="invalid-feedback errorshow" role="alert">
                                                </span>
                                            </div>

                                            <div class="col-sm-12 mb-3">
                                                <label for="description">{{ __('Description') }}<sup>*</sup></label>
                                                <input type="text" id="description" class="form-control" name="store_description" required>
                                                <span class="invalid-feedback errorshow" role="alert">
                                                </span>
                                            </div>

                                            <div class="col-sm-12 mb-3">
                                                <label for="address">{{ __('Address') }}</label>
                                                <input type="text" name="store_address" id="address" class="form-control">
                                                <span class="invalid-feedback errorshow" role="alert">
                                                    </span>
                                            </div>

                                            <div class="col-sm-12 mb-3">
                                                <label for="email">{{ __('Email') }} <sup>*</sup></label>
                                                <input type="text" name="store_email" id="email" class="form-control" required>
                                                <span class="invalid-feedback errorshow" role="alert">
                                                    </span>
                                            </div>

                                            <div class="col-sm-6">
                                                <label for="phone">{{ __('Phone') }} <sup>*</sup></label>
                                                <input type="text" name="store_phone" id="phone" class="form-control" required>
                                                <span class="invalid-feedback errorshow" role="alert">
                                                    </span>
                                            </div>

                                            <div class="col-sm-6">
                                                <label for="phone2">{{ __('Phone 2') }}</label>
                                                <input type="text" name="phone2" id="phone2" class="form-control">
                                                <span class="invalid-feedback errorshow" role="alert">
                                                    </span>
                                            </div>


                                        </div>


                                        <div class="row justify-content-center form-group">
                                            <div class="col-sm-12">
                                                <label for="about">{{ __('About') }}</label>
                                                <textarea class="form-control" name="store_about" id="about" cols="30" rows="5"></textarea>
                                                <span class="invalid-feedback errorshow" role="alert">
                                        </span>
                                            </div>


                                        </div>
                                        <div class="mt-1">
                                            <button class="btn float-right btn-primary btn-lg font-weight-medium add_product_btn" type="submit">
                                                <span>{{ __('Save') }}</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
</body>
</html>