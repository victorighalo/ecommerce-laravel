<form id="property_value_form">
    @csrf
    <div class="row form-group">
        <div class="col-sm-4">
            <label for="property_slug">{{ __('Variants') }}</label>
            <select class="form-control" name="property_slug" id="property_slug">
                @foreach($variants as $variant)
                    <option value="{{$variant->slug}}">{{$variant->name}}</option>
                @endforeach
            </select>
            <span class="invalid-feedback errorshow" role="alert"></span>
        </div>

        <div class="col-sm-4">
            <label for="property_value">{{ __('Variant value') }}</label>
            <input type="text" id="property_value" class="form-control" name="property_value" placeholder="300, Red"  required>
            <span class="invalid-feedback errorshow" role="alert">
                                        </span>
        </div>
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
            <button class="mt-4 mb-3 btn custom_button_color btn-warning btn-lg font-weight-medium add_property_value_btn" type="submit">
                <i class="fas fa-spinner fa-spin off process_indicator"></i>
                <span>{{ __('Create') }}</span>
            </button>
        </div>
    </div>
</form>
