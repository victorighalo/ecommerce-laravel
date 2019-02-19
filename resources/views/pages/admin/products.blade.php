@extends('layouts.admin')
@section('content')
    @include('partials.image-modal')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row justify-content-center flex-grow mb-5 mt-5">
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
                                                
                                                <div class="col-sm-4">
                                                    <label for="name">{{ __('Labels') }}</label>
                                                    <input type="text" id="label" class="form-control" name="labels" data-role="tagsinput"  required>
                                                    <span class="invalid-feedback errorshow" role="alert">
                                                </span>
                                                </div>      
                                                
                                                <div class="col-sm-4">
                                                    <label for="category_id">{{ __('Category') }}</label>
                                                    <select class="form-control" name="category_id" id="category_id">
                                                        @foreach($categories as $category)
                                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="invalid-feedback errorshow" role="alert">
                                                    </span>
                                                </div>
                                                
                                            </div>


                                            <div class="row justify-content-center form-group">
                                                <div class="col-sm-12">
                                                <label for="description">{{ __('Description') }}</label>
                                                <textarea class="form-control" name="description" id="" cols="30" rows="5"></textarea>
                                                <span class="invalid-feedback errorshow" role="alert">
                                        </span>
                                            </div>

                                                <div class="col-sm-12 mt-3">
                                                <div class="card text-left">
                                                    <div class="card-header">
                                                        <label for="description">{{ __('Images') }}</label>
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
            <div class="row">
                <div class="col-6 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Products</h5>
                            <div class="table-responsive">
                                <table class="table table-striped " id="categories-table">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Sub categories</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {{--@foreach($categories as $category)--}}
                                        {{--<tr>--}}
                                            {{--<td>--}}
                                                {{--{{$category->taxonomy_name}}--}}
                                            {{--</td>--}}
                                            {{--<td>--}}
                                                {{--<div class="row">--}}
                                                    {{--<div class="col-12 p-2">--}}
                                                        {{--{{$category->taxonomy_name}}--}}
                                                    {{--</div>--}}
                                                    {{--<div class="col-12 p-2">--}}
                                                        {{--{{$category->taxonomy_name}}--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</td>--}}
                                        {{--</tr>--}}
                                    {{--@endforeach--}}
                                    </tbody>
                                </table>
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
        const bsmodal = $('#images-modal');
        const mediafolder = "{{asset('')}}/";
        $(document).ready(function () {
            $("#load_images_btn").click(function () {
                $('#images-modal').modal('show')

                $.ajax({
                    url: "{{route('load_images')}}",
                    type: 'GET',
                })
                    .done(function(data) {
                        $(data).map( function(index, value){
                            var image = "{!! asset('') !!}"+value.file;
                            var id = value.id;
                            bsmodal.find('.modal-body').find('form').append(
                                `<div class="gallery_item image-container">
                    <img src="${image}" width="100px">
                    <input type='radio' name='gal_item' value="${id}" data-image_name="${image}" class="gallery_item_checkbox">
                    </div>`
                            )
                        })
                    }).fail(function(error) {

                });
            })

            // Add Images
            $("#add_images").click( function(){
                $("form[name='add_images_form']").find('input:radio:checked').map( function(index, value){
                    $(".chosen_images").append(
                        `<img src="${$(value).data('image_name')}" width="100px">`
                    )
                })
                $('#images-modal').modal('hide')

            })

            // Upload Action
            $("#upload_btn").click(function (event) {
                event.preventDefault();
                $(".upload_btn").prop('disabled', true)
                $(".upload_btn > .process_indicator").removeClass('off');
                if($("#files_upload").prop('files').length === 0){
                    new PNotify({
                        title: 'Oops!',
                        text: "No Content to upload",
                        type: 'error'
                    });
                    return false;
                }

                var uploaded_file = $("#files_upload").prop('files')[0];
                var form_data = new FormData();
                form_data.append('uploaded_file', uploaded_file);

                $.ajax({
                    url: "{{route('upload_product')}}", // point to server-side PHP script
                    data: form_data,
                    type: 'POST',
                    dataType:'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                })
                    .done(function(data) {
                        $("#upload_btn").prop('disabled', false)
                        $("#upload_btn > .process_indicator").removeClass('on');
                        if(data.status == 0){
                            new PNotify({
                                title: 'Oops!',
                                text: 'An Error Occurred. Please try again.',
                                addclass: 'custom_notification',
                                type: 'error'
                            });
                        }
                        else{
                            new PNotify({
                                title: 'Success!',
                                text: data.message,
                                addclass: 'custom_notification',
                                type: 'success'
                            });
                        }
                    }).fail(function(error) {
                    $("#upload_btn").prop('disabled', false)
                    $("#upload_btn > .process_indicator").removeClass('on');
                    new PNotify({
                        title: 'Oops!',
                        text: 'An Error Occurred. Please try again.',
                        addclass: 'custom_notification',
                        type: 'error'
                    });
                });

            });

            $("form#product_form").on('submit', function (e) {
                e.preventDefault();
                $(".add_product_btn").prop('disabled', true)
                $(".add_product_btn > .process_indicator").removeClass('off');
                $("span.errorshow").html("")
                $.ajax({
                    type: "POST",
                    url: "{!! route('create_products') !!}",
                    data: $(this).serialize()
                }).done(function (data) {
                    $(".add_product_btn").prop('disabled', false)
                    $(".add_product_btn > .process_indicator").addClass('off');
                    new PNotify({
                        title: 'Success!',
                        text: 'Product created.',
                        addclass: 'custom_notification',
                        type: 'success'
                    });
                }).fail(function (response) {
                    $(".add_product_btn").prop('disabled', false)
                    $(".add_product_btn > .process_indicator").addClass('off');
                    if (response.status == 500) {
                        new PNotify({
                            title: 'Oops!',
                            text: 'An Error Occurred. Please try again.',
                            addclass: 'custom_notification',
                            type: 'error'
                        });
                    }
                    if (response.status == 400) {
                        $.each(response.responseJSON.message, function (key, item) {
                            $("input[name="+key+"] + span.errorshow").html(item[0])
                            $("input[name="+key+"] + span.errorshow").slideDown("slow")
                        });
                        new PNotify({
                            title: 'Oops!',
                            text: 'Form validation error.',
                            type: 'error'
                        });
                    }
                    else {
                        new PNotify({
                            title: 'Oops!',
                            text: 'An Error Occurred. Please try again.',
                            type: 'error'
                        });
                    }
                })
            });

            $("form#sub_category_form").on('submit', function (e) {
                e.preventDefault();
                $(".add_sub_category_btn").prop('disabled', true)
                $(".add_sub_category_btn > .process_indicator").removeClass('off');
                $("span.errorshow").html("")
                $.ajax({
                    type: "POST",
                    url: "{!! route('create_sub_category') !!}",
                    data: $(this).serialize()
                }).done(function (data) {
                    $(".add_sub_category_btn").prop('disabled', false)
                    $(".add_sub_category_btn > .process_indicator").addClass('off');
                    new PNotify({
                        title: 'Success!',
                        text: 'Category created.',
                        addclass: 'custom_notification',
                        type: 'success'
                    });
                }).fail(function (response) {
                    $(".add_sub_category_btn").prop('disabled', false)
                    $(".add_sub_category_btn > .process_indicator").addClass('off');
                    if (response.status == 500) {
                        new PNotify({
                            title: 'Oops!',
                            text: 'An Error Occurred. Please try again.',
                            addclass: 'custom_notification',
                            type: 'error'
                        });
                    }
                    if (response.status == 400) {
                        $.each(response.responseJSON.message, function (key, item) {
                            $("input[name="+key+"] + span.errorshow").html(item[0])
                            $("input[name="+key+"] + span.errorshow").slideDown("slow")
                        });
                        new PNotify({
                            title: 'Oops!',
                            text: 'Form validation error.',
                            type: 'error'
                        });
                    }
                    else {
                        new PNotify({
                            title: 'Oops!',
                            text: 'An Error Occurred. Please try again.',
                            type: 'error'
                        });
                    }
                })
            });


        });
    </script>
@endpush