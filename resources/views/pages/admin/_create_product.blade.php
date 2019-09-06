<div class="row justify-content-center flex-grow mb-5 mt-1">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div style="border-bottom: #8c8c8c 1px solid; padding-bottom: 20px">
                <button class="btn float-right btn-primary btn-lg font-weight-medium add_product_btn" type="button">
                    <i class="fas fa-spinner fa-spin off process_indicator"></i>
                    <span><i class="fas fa-save"></i> {{ __('Save') }}</span>
                </button>
                <h5 class="card-title">  ADD PRODUCT
{{--                    <a class="btn btn-link float-right" data-toggle="collapse" href="#form_collapse" role="button" aria-expanded="false" aria-controls="collapseExample">--}}
{{--                        <i class="fas fa-ellipsis-v"></i>--}}
{{--                    </a>--}}
                </h5>
                </div>
                <div id="form_collapse" style="margin-top:35px">
                    <div class="row">
                        <div class="col-sm-12 p-4">
                            <form id="product_form">
                                @csrf
                                <div class="row">
                                <div class="col-sm-8">
                                <div class="row form-group">
                                    <div class="col-sm-8">
                                        <label for="name">{{ __('Product title') }}</label>
                                        <input type="text" id="name" class="form-control" name="name" required>
                                        <span class="invalid-feedback errorshow" role="alert">
                                                </span>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="category_id">{{ __('Category') }}</label>
                                        <select class="form-control" name="taxon_slug" id="taxon_slug">
                                            @foreach($categories as $category)
                                                <option value="{{$category->slug}}">{{$category->taxonomy->name}} - {{$category->name}} </option>
                                                @foreach($category->children as $child_category)
                                                    <option value="{{$child_category->slug}}">{{$category->taxonomy->name}} - {{$category->name}} - {{$child_category->name}} </option>
                                                @endforeach
                                            @endforeach
                                        </select>
                                        <span class="invalid-feedback errorshow" role="alert">
                                                    </span>
                                    </div>

                                    <div class="col-sm-12 pt-4">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <label for="price">{{ __('Price') }}</label>
                                                <input type="number" name="price" value="0" class="form-control" required>
                                                <span class="invalid-feedback errorshow" role="alert">
                                                    </span>
                                            </div>

                                            <div class="col-sm-3">
                                                <label for="delivery_price">{{ __('Delivery Price') }}</label>
                                                <input type="number" name="delivery_price" value="0" class="form-control" required>
                                                <span class="invalid-feedback errorshow" role="alert">
                                                    </span>
                                            </div>

                                            <div class="col-sm-6">
                                                <label for="name">{{ __('Product Tags') }}</label>
                                                <input type="text" id="tags" class="form-control" name="tags" data-role="tagsinput"  required>
                                                <span class="invalid-feedback errorshow" role="alert">
                                                </span>
                                            </div>

                                    </div>
                                    </div>

                                </div>

                                <div class="row justify-content-start form-group">
                                    <div class="col-sm-12 pt-3">
                                        <label for="description">{{ __('Product Description') }}</label>
                                        <textarea class="form-control" name="meta_description" id="" cols="30" rows="2"></textarea>
                                        <span class="invalid-feedback errorshow" role="alert">
                                        </span>
                                    </div>
                                    <div class="col-sm-12 pt-4 property_values  ">
                                        <div><label for="">{{ __('Properties') }}</label></div>
                                    @foreach($properties as $property)
                                            <label for="">{{$property->name}}
                                            <select name="product_property" id="{{$property->id}}" class="form-control" style="
                                            display: inline;
                                            width: auto;">
                                                <option value="null">None</option>
                                            @foreach($property->values() as $value)
                                                    <option value="{{$value->id}}">{{$value->value}}</option>
{{--                                                    <option value="{{$value->id}}">{{$value->value}} {{$value->title}}</option>--}}
                                        @endforeach
                                            </select>
                                            </label>
                                        @endforeach
                                        @if(count($properties) < 1)
                                            <p>No properties to display</p>
                                            @endif
                                    </div>
                                    <div class="col-sm-12 pt-4">
                                        <div class="text-left">
                                                <label for="overview">{{ __('Product Overview') }}</label>
                                            <div id="editor">

                                            </div>
                                            <span class="invalid-feedback errorshow" role="alert">
                                        </span>
                                        </div>
                                    </div>

                                </div>

                                </div>
                                        <div class="col-sm-4">
                                            <div class="card text-left">
                                                <div class="card-header">
                                                    <label for="">{{ __('Product Images') }}</label>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <label>Image upload</label>
                                                            <div class="input-group">
                                                                <input type="file" name="img[]" class="file-upload-default">
                                                                <input type="file" class="form-control file-upload-info" id="files_upload" placeholder="Upload Image">
                                                                <span class="input-group-append">
                                                        <button class="file-upload-browse btn custom_button_color" type="button" id="upload_btn"><i class="fas fa-upload"></i> Upload</button>
                                                        </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 mt-5">
                                                            <label>Select images for the product</label><br>
                                                            <a href="#" class="btn custom_button_color"  id="load_images_btn"><i class="fas fa-image"></i> Choose images</a>
                                                        </div>
                                                    </div>
                                                    <div class="chosen_images mt-3">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-5">
                                                <button class="btn float-right btn-primary btn-lg btn-block font-weight-medium add_product_btn" type="button">
                                                    <i class="fas fa-spinner fa-spin off process_indicator"></i>
                                                    <span><i class="fas fa-save"></i> {{ __('Save') }}</span>
                                                </button>
                                            </div>
                                        </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
