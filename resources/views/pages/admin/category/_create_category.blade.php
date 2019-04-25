<div class="col-sm-12 p-4">
    <form id="category_form">
        @csrf
        <div class="row form-group">
            <label for="name">{{ __('Category name') }}</label>
            <input type="text" id="name" class="form-control" name="name" required>
            <span class="invalid-feedback errorshow" role="alert">
                                        </span>
        </div>
            <div class="mt-1 row justify-content-end">
            <button class="btn float-right custom_button_color btn-warning btn-lg font-weight-medium add_category_btn mt-2" type="submit">
                <i class="fas fa-spinner fa-spin off process_indicator"></i>
                <span>{{ __('Create') }}</span>
            </button>
        </div>
    </form>


    <form id="sub_category_form">
        @csrf
        <div class="row form-group border-top pt-4 mt-4">
            <label for="category_id">{{ __('Categories') }}</label>
            <select class="form-control" name="category_id" id="category_id">
                @foreach($categories as $category)
                    <option value="{{$category->taxonomy_id}}">{{$category->taxonomy_name}}</option>
                @endforeach
            </select>
            <span class="invalid-feedback errorshow" role="alert">
                                        </span>
        </div>

        <div class="row form-group">
            <label for="sub_category">{{ __('Sub category') }}</label>
            <input type="text" id="sub_category" class="form-control" name="sub_category"  required>
            <span class="invalid-feedback errorshow" role="alert">
                                        </span>
        </div>
        <div class="mt-1 row justify-content-end">
            <button class="btn custom_button_color btn-warning btn-lg font-weight-medium add_sub_category_btn" type="submit">
                <i class="fas fa-spinner fa-spin off process_indicator"></i>
                <span>{{ __('Create') }}</span>
            </button>
        </div>
    </form>
</div>