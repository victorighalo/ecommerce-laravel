<div class="card">
    <div class="card-body">
        <h5 class="card-title mb-4">Create a Product Property</h5>
<form id="property_value_form">
    @csrf
    <div class="row form-group">
        <div class="col-sm-4">
            <label for="property_slug">{{ __('Select a Property') }}</label>
            <select class="form-control" name="property_slug" id="property_slug">
                @foreach($properties as $property)
                    <option value="{{$property->slug}}">{{$property->name}}</option>
                @endforeach
            </select>
            <span class="invalid-feedback errorshow" role="alert"></span>
        </div>

        <div class="col-sm-4">
            <label for="property_value">{{ __('Property value') }}</label>
            <input type="text" id="property_value" class="form-control" name="property_value" placeholder="300, Red"  required>
            <span class="invalid-feedback errorshow" role="alert">
                                        </span>
        </div>
        <div class="col-sm-4">
            <label for="property_title">{{ __('Property title') }} (optional)</label>
            <input type="text" id="property_title" class="form-control" value=" " name="property_title" placeholder="Kg" >
            <span class="invalid-feedback errorshow" role="alert">
                                        </span>
        </div>
        <div class="mt-1 w-100">
            <button class="mt-3 mb-3 btn btn-sm float-right custom_button_color btn-warning btn-lg font-weight-medium add_property_value_btn" type="submit">
                <i class="fas fa-spinner fa-spin off process_indicator"></i>
                <span>{{ __('Create') }}</span>
            </button>
        </div>
    </div>
</form>
    </div>
</div>
