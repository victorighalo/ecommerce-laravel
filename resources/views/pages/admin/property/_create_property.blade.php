<form id="property_form">
    @csrf
    <div class="row form-group">
        <div class="col-sm-8">
            <label for="name">{{ __('Property name') }}</label>
            <input type="text" id="name" class="form-control" name="name" required>
            <span class="invalid-feedback errorshow" role="alert"> </span>
        </div>

        <div class="col-sm-4">
            <label for="property_type">{{ __('Property type') }}</label>
            <select name="property_type" class="form-control" id="property_type">
                <option value="text">Text</option>
                <option value="number">Number</option>
                <option value="boolean">True/False</option>
            </select>
            <span class="invalid-feedback errorshow" role="alert"> </span>
        </div>
        <div class="mt-1 w-100">
            <button class="float-right btn custom_button_color btn-warning btn-lg font-weight-medium add_property_btn mt-3 mb-3 " type="submit">
                <i class="fas fa-spinner fa-spin off process_indicator"></i>
                <span>{{ __('Create') }}</span>
            </button>
        </div>
    </div>
</form>
