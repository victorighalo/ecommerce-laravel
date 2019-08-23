<div class="row justify-content-center">
    <div class="col-sm-8 p-4 mb-5">
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
            <form id="product_form" action="{{action('SettingController@update')}}" method="post">
                @csrf
                @method('PUT')
                <div class="row form-group">
                    <div class="col-sm-6 mb-3">
                        <label for="store_name">{{ __('App name') }}</label>
                        <input type="text" id="store_name" value="{{$app_settings->store_name}}" name="store_name" class="form-control" required>
                        <span class="invalid-feedback errorshow" role="alert">
                                                </span>
                    </div>

                    <div class="col-sm-12 mb-3">
                        <label for="description">{{ __('Description') }}</label>
                        <input type="text" id="description" value="{{$app_settings->store_description}}" name="store_description" class="form-control" name="description" required>
                        <span class="invalid-feedback errorshow" role="alert">
                                                </span>
                    </div>

                    <div class="col-sm-12 mb-3">
                        <label for="store_address">{{ __('Address') }}</label>
                        <input type="text" name="store_address" id="store_address" value="{{$app_settings->store_address}}" class="form-control">
                        <span class="invalid-feedback errorshow" role="alert">
                                                    </span>
                    </div>
                </div>

                    <div class="card">
                        <div class="card-header">
                            <h4>Contact details</h4>
                        </div>
                    <div class="row form-group p-3">

                    <div class="col-sm-4 mb-3">
                        <label for="store_email">{{ __('Email') }}</label>
                        <input type="text" name="store_email" id="store_email" value="{{$app_settings->store_email}}" class="form-control">
                        <span class="invalid-feedback errorshow" role="alert">
                                                    </span>
                    </div>

                    <div class="col-sm-4">
                        <label for="store_twitter">{{ __('Twitter') }}</label>
                        <input type="url" name="store_twitter" value="{{$app_settings->store_twitter}}" id="store_twitter" class="form-control">
                        <span class="invalid-feedback errorshow" role="alert">
                                                    </span>
                    </div>

                    <div class="col-sm-4 mb-3">
                        <label for="store_facebook">{{ __('Facebook') }}</label>
                        <input type="url" name="store_facebook" id="store_facebook" value="{{$app_settings->store_facebook}}" class="form-control">
                        <span class="invalid-feedback errorshow" role="alert">
                                                    </span>
                    </div>

                    <div class="col-sm-4">
                        <label for="store_instagram">{{ __('Instagram') }}</label>
                        <input type="url" name="store_instagram" value="{{$app_settings->store_instagram}}" id="store_instagram" class="form-control">
                        <span class="invalid-feedback errorshow" role="alert">
                                                    </span>
                    </div>

                    <div class="col-sm-4 mb-3">
                        <label for="store_linkedin">{{ __('Linkedin') }}</label>
                        <input type="url" name="store_linkedin" id="store_linkedin" value="{{$app_settings->store_linkedin}}" class="form-control">
                        <span class="invalid-feedback errorshow" role="alert">
                                                    </span>
                    </div>

                    <div class="col-sm-4 mb-3">
                        <label for="store_youtube">{{ __('YouTube') }}</label>
                        <input type="url" name="store_youtube" id="store_youtube" value="{{$app_settings->store_youtube}}" class="form-control">
                        <span class="invalid-feedback errorshow" role="alert">
                                                    </span>
                    </div>

                    <div class="col-sm-6">
                        <label for="phone">{{ __('Phone') }}</label>
                        <input type="phone" value="{{$app_settings->store_phone}}" name="store_phone" id="phone" class="form-control">
                        <span class="invalid-feedback errorshow" role="alert">
                                                    </span>
                    </div>
                    </div>
                    </div>




                <div class="row justify-content-center form-group">
                    <div class="col-sm-12 p-4">
                        <label for="about">{{ __('About') }}</label>
                        <textarea class="form-control" name="about" id="about" cols="30" rows="5">{{$app_settings->store_about}}</textarea>
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
