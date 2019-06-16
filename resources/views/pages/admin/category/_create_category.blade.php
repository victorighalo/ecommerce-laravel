 <div class="row form-group">

            <div class="col-sm-12">
                <form id="category_form">
                    @csrf
                    <div class="row form-group">
                        <label for="name">{{ __('Category name') }} (First level)</label>
                        <div class="input-group mb-3">
                        <input type="text" id="name" class="form-control" name="name" required>
                            <div class="input-group-append">
                        <button class="btn custom_button_color font-weight-medium add_category_btn" type="submit">
                            <i class="fas fa-spinner fa-spin off process_indicator"></i>
                            <span>{{ __('Create') }}</span>
                        </button>
                            </div>
                    </div>
                    </div>
                </form>

            </div>
            <div class="col-sm-12">
                <form id="sub_category_form">
                    @csrf
                    <div class="row form-group">
                    <div class="mb-3 col-12">
                <label for="category_id">{{ __('Categories') }} (First level)</label>
                <select class="form-control" name="category_id" id="category_id">
                    @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
                <span class="invalid-feedback errorshow" role="alert">
                </span>
                    </div>
            <div class="col-12">
                <label for="sub_category">{{ __('Sub category') }} (Second level)</label>
                <input type="text" id="sub_category" class="form-control" name="sub_category"  required>
                <span class="invalid-feedback errorshow" role="alert">
                                        </span>

                <div class="mt-3 justify-content-end">
                    <button class="btn custom_button_color btn-warning btn-lg font-weight-medium add_sub_category_btn float-right" type="submit">
                        <i class="fas fa-spinner fa-spin off process_indicator"></i>
                        <span>{{ __('Create') }}</span>
                    </button>
                </div>
            </div>
            </div>
            </form>
        </div>


        </div>

