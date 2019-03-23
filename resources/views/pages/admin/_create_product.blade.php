<div class="row justify-content-center flex-grow mb-5 mt-1">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">  Create Product
                    <a class="btn btn-link float-right" data-toggle="collapse" href="#form_collapse" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <i class="fas fa-ellipsis-v"></i>
                    </a></h4>
                <div class="collapse" id="form_collapse">
                    <div class="row">
                        <div class="col-sm-12 p-4">
                            <form id="product_form">
                                @csrf
                                <div class="row form-group">
                                    <div class="col-sm-4">
                                        <label for="name">{{ __('Product name') }}</label>
                                        <input type="text" id="name" class="form-control" name="name" required>
                                        <span class="invalid-feedback errorshow" role="alert">
                                                </span>
                                    </div>

                                    <div class="col-sm-3">
                                        <label for="name">{{ __('Tags') }}</label>
                                        <input type="text" id="tags" class="form-control" name="tags" data-role="tagsinput"  required>
                                        <span class="invalid-feedback errorshow" role="alert">
                                                </span>
                                    </div>

                                    <div class="col-sm-3">
                                        <label for="category_id">{{ __('Category') }}</label>
                                        <select class="form-control" name="category_id" id="category_id">
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->name}} - {{$category->taxonomy->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="invalid-feedback errorshow" role="alert">
                                                    </span>
                                    </div>

                                    <div class="col-sm-2">
                                        <label for="price">{{ __('Price') }}</label>
                                        <input type="number" name="price" class="form-control" required>
                                        <span class="invalid-feedback errorshow" role="alert">
                                                    </span>
                                    </div>

                                </div>


                                <div class="row justify-content-start form-group">
                                    <div class="col-sm-6">
                                        <label for="description">{{ __('Description') }}</label>
                                        <textarea class="form-control" name="meta_description" id="" cols="30" rows="2"></textarea>
                                        <span class="invalid-feedback errorshow" role="alert">
                                        </span>
                                    </div>
                                    <div class="col-sm-12 mt-4">
                                        <div><label for="">{{ __('Properties') }}</label></div>
                                    @foreach($properties as $property)
                                            <label for="">{{$property->name}}
                                            <select name="{{$property->slug}}" id="" class="form-control" style="
                                            display: inline;
                                            width: auto;">
                                        @foreach($property->values() as $value)
                                                    <option value="{{$value->value}}">{{$value->value}} {{$value->title}}</option>
                                        @endforeach
                                            </select>
                                            </label>
                                        @endforeach
                                    </div>
                                    <div class="col-sm-12 mt-4">
                                        <div class=" text-left">

                                                <label for="overview">{{ __('Overview') }}</label>

                                            <div id="editor">

                                            </div>
                                            <span class="invalid-feedback errorshow" role="alert">
                                        </span>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 mt-5">
                                        <div class="card text-left">
                                            <div class="card-header">
                                                <label for="">{{ __('Images') }}</label>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label>File upload</label>
                                                    <input type="file" name="img[]" class="file-upload-default">
                                                    <div class="input-group col-xs-12">
                                                        <input type="file" class="form-control file-upload-info" id="files_upload" placeholder="Upload Image">
                                                        <span class="input-group-append">
                                                        <button class="file-upload-browse btn custom_button_color" type="button" id="upload_btn">Upload</button>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <a href="#" class="btn custom_button_color"  id="load_images_btn">Choose images</a>
                                                </div>
                                                <div class="chosen_images mt-3">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-1">
                                    <button class="btn float-right btn-primary btn-lg font-weight-medium add_product_btn" type="submit">
                                        <i class="fas fa-spinner fa-spin off process_indicator"></i>
                                        <span>{{ __('Create') }}</span>
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
