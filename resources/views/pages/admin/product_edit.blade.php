@extends('layouts.admin')
@section('content')
    @include('partials.image-modal')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row justify-content-center flex-grow mb-5 mt-5">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">  Edit Product
                                <a class="btn btn-link float-right" data-toggle="collapse" href="#form_collapse" role="button" aria-expanded="false" aria-controls="collapseExample">
                                    <i class="fas fa-ellipsis-v"></i>
                                </a></h4>
                            <div>
                                <div class="row">
                                    <div class="col-sm-12 p-4">
                                        <form id="product_form">
                                            @csrf
                                            <div class="row form-group">
                                                <input type="hidden" name="id" value="{{$product->id}}">
                                                <div class="col-sm-4">
                                                    <label for="name">{{ __('Product name') }}</label>
                                                    <input type="text" id="name" class="form-control" name="name" value="{{$product->title}}" required>
                                                    <span class="invalid-feedback errorshow" role="alert">
                                                </span>
                                                </div>

                                                <div class="col-sm-3">
                                                    <label for="name">{{ __('Tags') }}</label>
                                                    <input type="text" id="tags" class="form-control" name="tags" data-role="tagsinput" value="{{$product->meta_keywords}}"  required>
                                                    <span class="invalid-feedback errorshow" role="alert">
                                                </span>
                                                </div>

                                                <div class="col-sm-3">
                                                    <label for="category_id">{{ __('Category') }}</label>
                                                    <select class="form-control" name="category_id" id="category_id">
                                                        @foreach($categories as $category)
                                                            @if(count($product->taxons))
                                                                @if($product->taxons->first()->name == $category->name)
                                                            <option value="{{$category->id}}" selected>{{$category->name}}</option>
                                                                @else
                                                                    <option value="{{$category->id}}">{{$category->name}} - {{$category->taxonomy->name}}</option>
                                                                @endif
                                                                @else
                                                                    <option value="{{$category->id}}">{{$category->name}} - {{$category->taxonomy->name}}</option>
                                                            @endif
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


                                            <div class="row justify-content-center form-group">
                                                <div class="col-sm-12">
                                                    <label for="description">{{ __('Description') }}</label>
                                                    <textarea class="form-control" name="description" id="" cols="30" rows="5">{{$product->description}}</textarea>
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
                                                                @foreach($product->getMedia('images')->all() as $image)
                                                                    <div class="product_img_container">
                                                                        <div class="product_img_container_delete">
                                                                            <span style="cursor:pointer;" class="badge badge-danger" data-imageid="{{$image->id}}" onclick="removeSpatieMedia(this)">x</span>
                                                                        </div>
                                                             <img src="{{$image->getFullUrl()}}" value="{{$image->id}}"  width='100px'>
                                                                    {{--<span style="cursor:pointer;" class="badge badge-danger" onclick="removeSpatieMedia({{$image->id}})">x</span>--}}
                                                                    </div>
                                                                        @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-1">
                                                <button class="btn float-right btn-primary btn-lg font-weight-medium add_product_btn" type="submit">
                                                    <i class="fas fa-spinner fa-spin off process_indicator"></i>
                                                    <span>{{ __('Update') }}</span>
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
        var bsmodal = $('#images-modal');
        var imageBag = [];
        $(document).ajaxStop($.unblockUI);

        $(document).ready(function () {
            //load images to modal
            $("#load_images_btn").click(function () {
                $('#images-modal').modal('show')
                $('.modal-content').block({
                    message: '<h5>Loading...</h5>',
                    css: {border: '1px solid #fff'}
                });
                $.ajax({
                    url: "{{route('load_images')}}",
                    type: 'GET',
                })
                    .done(function (data) {
                        $('.modal-content').unblock();
                        bsmodal.find('.modal-body').find('form').empty();
                        $(data).map(function (index, value) {
                            var image = "{!! asset('') !!}" + value.file;
                            var id = value.id;
                            bsmodal.find('.image_load_status').html("")
                            bsmodal.find('.modal-body').find('form').append(
                                `<div style="display:inline-block ;" data-imageid="${id}">
                    <img src="${image}" width="100px" height="80px">
                    <input type='checkbox' name='gal_item' value="${id}" data-image_link="${image}" data-image_path="${value.file}" class="gallery_item_checkbox">
                    <span style="cursor:pointer;" class="badge badge-danger" id="${id}" onclick="removeMedia(this)">x</span>
                    </div>
                    `
                            )
                        })
                    }).fail(function (error) {
                    bsmodal.find('.image_load_status').html("Failed to load images. Please Try again.")
                    $('.modal-content').unblock();
                });
            });

            // Add Images to product
            $("#add_images").click(function () {
                imageBag = [];
                $("form[name='add_images_form']").find('input:checkbox:checked').map(function (index, value) {
                    var img_path = $(value).data('image_path');
                    imageBag.push(img_path)
                    $(".chosen_images").append(
                        `<div class="product_img_container">
                            <div class="product_img_container_delete">
                            <span style="cursor:pointer;" class="badge badge-danger" data-imgpath="${img_path}" onclick="popImage(this)">x</span>
                            </div>
                            <img src="${$(value).data('image_link')}" width="100px" height="80px">
                        </div>
                        `
                    )
                })
                $('#images-modal').modal('hide')

            });

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
                $.blockUI({message: '<h5>Uploading...</h5>'});
                $.ajax({
                    url: "{{route('media_upload')}}", // point to server-side PHP script
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

            //Create product
            $("form#product_form").on('submit', function (e) {
                e.preventDefault();
                $(".add_product_btn").prop('disabled', true)
                $(".add_product_btn > .process_indicator").removeClass('off');
                $("span.errorshow").html("")

                var form_data = new FormData();
                // form_data.append('form_data', $(this).serialize());
                form_data.append('images', imageBag);
                $.ajax({
                    type: "POST",
                    url: "{!! route('update_product') !!}",
                    data: {form_data:$(this).serialize(), images: imageBag}
                }).done(function (data) {
                    $(".add_product_btn").prop('disabled', false)
                    $(".add_product_btn > .process_indicator").addClass('off');
                    new PNotify({
                        title: 'Success!',
                        text: 'Product updated.',
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

        });

        function popImage(e) {
            $(e).parent().parent().fadeOut()
            imageBag = imageBag.filter( function (item) {
                return item != $(e).data('imgpath');
            })
        }

        function removeMedia (media) {
        var item = $(media);
            PNotify.removeAll();
            new PNotify({
                title: 'Confirm Removal',
                text: 'Are you sure?',
                icon: 'glyphicon glyphicon-question-sign',
                addclass: 'custom_notification',
                hide: false,
                confirm: {
                    confirm: true,
                    buttons: [{
                        text: 'Delete',
                        addClass: 'btn-primary',
                        click: function(notice) {
                            $.ajax({
                                url: "{{route('media_remove')}}",
                                type: 'POST',
                                data: {mediaId: item.attr('id') }
                            }).done(function (data) {
                                notice.update({
                                    title: 'Success',
                                    text: 'Removal successful.',
                                    icon: true,
                                    type: 'success',
                                    hide: true,
                                    confirm: {
                                        confirm: false
                                    },
                                    buttons: {
                                        closer: true,
                                        sticker: true
                                    }
                                });
                                item.parent().fadeOut();
                            }).fail(function (response) {
                                PNotify.removeAll();
                                if (response.status == 500) {
                                    new PNotify({
                                        title: 'Oops!',
                                        text: 'An Error Occurred. Please try again.',
                                        type: 'error'
                                    });
                                    return false
                                }
                                if (response.status == 400) {
                                    new PNotify({
                                        title: 'Oops!',
                                        text: 'Failed to delete image.',
                                        type: 'error'
                                    });
                                    return false
                                }
                                else {
                                    new PNotify({
                                        title: 'Oops!',
                                        text: 'An Error Occurred. Please try again.',
                                        type: 'error'
                                    });
                                    return false
                                }
                            })
                        }
                    },
                        {
                            text: 'Cancel',
                            addClass: 'btn-primary',
                            click: function(notice) {
                                notice.update({
                                    title: 'Action Cancelled',
                                    text: 'That was close...',
                                    icon: true,
                                    type: 'danger',
                                    hide: true,
                                    confirm: {
                                        confirm: false
                                    },
                                    buttons: {
                                        closer: true,
                                        sticker: true
                                    }
                                });
                            }
                        }]
                },
                buttons: {
                    closer: true,
                    sticker: true
                },
                history: {
                    history: false
                }
            })
        };

        function removeSpatieMedia (e) {
            var id = $(e).data('imageid');
            $.blockUI(
                {message: '<h5>Deleting...</h5>',
                css: {border: '1px solid #fff' }}
                );
            $.ajax({
        url: "{{route('media_remove_spatie')}}",
        type: 'POST',
        data: {id: id}
        })
        .done(function(data) {
            $.unblockUI();
            $(e).parent().parent().fadeOut();
            new PNotify({
                title: 'Success!',
                text: 'Image Deleted.',
                type: 'success'
            });
        }).fail(function(error) {
                $.unblockUI();
            new PNotify({
                title: 'Oops!',
                text: 'Failed to delete image.',
                type: 'error'
            });
        });

        };
    </script>
@endpush