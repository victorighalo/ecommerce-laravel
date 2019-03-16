@extends('layouts.admin')
@section('content')
    @include('partials.image-modal')
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
                                        <form id="product_form">
                                            @csrf
                                            <div class="row form-group">
                                                <div class="col-sm-12 mb-3">
                                                    <label for="name">{{ __('App name') }}</label>
                                                    <input type="text" id="name" class="form-control" name="name" required>
                                                    <span class="invalid-feedback errorshow" role="alert">
                                                </span>
                                                </div>

                                                <div class="col-sm-12 mb-3">
                                                    <label for="description">{{ __('Description') }}</label>
                                                    <input type="text" id="description" class="form-control" name="description" required>
                                                    <span class="invalid-feedback errorshow" role="alert">
                                                </span>
                                                </div>

                                                <div class="col-sm-12 mb-3">
                                                    <label for="address">{{ __('Address') }}</label>
                                                    <input type="text" name="address" id="address" class="form-control">
                                                    <span class="invalid-feedback errorshow" role="alert">
                                                    </span>
                                                </div>

                                                <div class="col-sm-12 mb-3">
                                                    <label for="email">{{ __('Email') }}</label>
                                                    <input type="text" name="email" id="email" class="form-control">
                                                    <span class="invalid-feedback errorshow" role="alert">
                                                    </span>
                                                </div>

                                                <div class="col-sm-6">
                                                    <label for="phone">{{ __('Phone') }}</label>
                                                    <input type="text" name="phone" id="phone" class="form-control">
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
                                                    <textarea class="form-control" name="about" id="about" cols="30" rows="5"></textarea>
                                                    <span class="invalid-feedback errorshow" role="alert">
                                        </span>
                                                </div>


                                            </div>
                                            <div class="mt-1">
                                                <button class="btn float-right btn-primary btn-lg font-weight-medium add_product_btn" type="submit">
                                                    <i class="fas fa-spinner fa-spin off process_indicator"></i>
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
@endsection

@push('script')
    <script src="{{asset('plugins/bootstrap-tagsinput.min.js')}}"></script>
    <script>

    </script>
@endpush