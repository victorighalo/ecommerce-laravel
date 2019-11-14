@extends('layouts.admin')
@section('content')
    @include('partials.image-modal')
    @include('partials.property_edit_modal')
    <div class="main-panel">
        <div class="content-wrapper">
            @include('pages.admin.products._create_product')
        </div>
    </div>
@endsection

@push('script')
    <script src="{{asset('plugins/bootstrap-tagsinput.min.js')}}"></script>
    <script src="{{asset('js/angular.min.js')}}"></script>

    <script>
        var imageBag = [];
        var toolbarOptions = [
            ['link', 'image'],
            ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
            ['blockquote', 'code-block'],
            [{'list': 'ordered'}, {'list': 'bullet'}],
            [{'script': 'sub'}, {'script': 'super'}],      // superscript/subscript
            [{'indent': '-1'}, {'indent': '+1'}],          // outdent/indent

            [{'header': [1, 2, 3, 4, 5, 6, false]}],

            [{'color': []}, {'background': []}],          // dropdown with defaults from theme
            [{'font': []}],
            [{'align': []}],

            ['clean']
        ];
        var options = {
            placeholder: 'Product overview...',
            readOnly: false,
            theme: 'snow',
            modules: {
                toolbar: toolbarOptions
            }
        };
        var description_container = $('#editor').get(0);
        var quill = new Quill(description_container, options);

        var bsmodal = $('#images-modal');
        var mediaUrl = "{{asset('')}}/";
        var productId;
        var properties = {};
        var variants = [];

        (function () {
            if (photoDriver == 'local') {
                mediaUrl = "{{asset('')}}"
            }
            else if (photoDriver == 's3') {
                mediaUrl = s3Url;
            }
        })();


        function displayVariants(variants){
            var row = "<div class='col-sm-6 mb-3 variant-container'>";
            row += "<div class='variant-box d-flex justify-content-around'>";
            row += "<div class='variant-desc text-center'>";
            row += "<div><p class=''>"+variants+"</p></div>";
            row += "</div>"
            row += "<div class='variant-box'>";
            row += "<div class='variant-price text-center'>";
            row += "<div><input class='form-control' type='number'></div>"
            row += "</div>"
            // row += "<i class=\"fas fa-trash variant-icon\"></i>"
            row += "</div></div>";
            $(".variants_preview").append(row)
        }

        function updateOrCreateVariant(element){
            //Check if variant exists in variants array
            var empty = 0;
            var itemExists = variants.some(function (val) {
                return  val.property_id == $(element.target).data('property_id')
            })

            if(itemExists) {
                //if item exists, update item in variants array
                variants.map(function (val, index) {
                    if (val.property_id == $(element.target).data('property_id')) {
                        val.variant_value = val.variant_value + "," +element.item
                    }
                })
            }else{
                //item does not exist, so add an item
                variants.push({
                    property_id: $(element.target).data('property_id'),
                    property_name: $(element.target).data('property_name'),
                    variant_value: element.target.value
                })
            }

            variants.map(function (val, index) {
                if (val.variant_value.length > 0) {
                    empty = 1;
                } else {
                    empty = 0
                }
            });
            if(empty == 1){
                return true
            }else{
                return false
            }
        }

        function removeVariant(element){
                //remove item from variants array
            var empty = 0;
                variants.map(function (val, index) {
                    if (val.property_id == $(element.target).data('property_id')) {
                        var new_value = val.variant_value.split(",").filter(function (item) {
                            return item !== element.item
                        })
                        val.variant_value = new_value.join()
                    }
                });

            variants.map(function (val, index) {
                if (val.variant_value.length > 0) {
                    empty = 1;
                } else {
                    empty = 0
                }
            });

                if(empty == 1){
                    return true
                }else{
                    return false
                }
        }

        $(document).ready(function () {
            $(".variants").on('itemAdded itemRemoved', function(event) {
                var proceed = true;
                if(event.type == 'itemAdded'){
                    proceed = updateOrCreateVariant(event)
                }else{
                    proceed = removeVariant(event)
                }

                // var variants_length = $("input.variants").length
                // var combo = "";
                // // $(".variants_preview").empty();
                // for (var i = 0; i < variants_length; i++){
                //
                //     $.each($("input.variants")[i].value.split(","), function (index, item) {
                //         if(item !== "" ){
                //             combo += item + "/"
                //             // var current_property = $(event.target)
                //         }
                //     })
                // }
                $(".variants_preview").empty()
                // console.log(variants.length)
                console.log(variants)
                console.log(proceed)
                if(proceed) {
                    if (variants.length > 1) {
                        console.log('show variants')
                        // for (var i = 0; i < variants.length; i++){
                        $.each(variants[0].variant_value.split(","), function (index, first_variant) {
                            try {

                                $.each(variants[1].variant_value.split(","), function (index, second_variant) {
                                    displayVariants(first_variant + "/" + second_variant)
                                })

                            } catch (e) {
                                // console.log("Err" + e)
                            }
                        })

                        // }
                    } else {
                        $.each(variants[0].variant_value.split(","), function (index, item) {
                            displayVariants(item)
                        })
                        // console.log(variants[0].variant_value.split(","))
                    }
                }


                // dissplayVariants(combo)

                // console.log($("input.variants")[0].value.split(","))
                // console.log($("input.variants")[1].value)

            });


            $(".show_variants_toggle").on("click", function (e) {
                if($(this).is(":checked")){
                    $(".show_variants").toggle()
                }else{
                    $(".show_variants").toggle()
                }
            })

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
                            var image = mediaUrl + value.file;
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

                $("form[name='add_images_form']").find('input:checkbox:checked').map(function (index, value) {
                    var img_path = $(value).data('image_path');

                    //Add image to imagebag array
                    // check if image exists before adding to the images array

                    if(imageBag.length) {//check if array is empty

                            if (imageBag.indexOf(img_path) === -1) {

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
                            }else{
                                // console.log('exists')
                            }

                    }else{
                        //if array is empty add the first image
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
                    }

                })

                $('#images-modal').modal('hide')


            });

            // Upload Action
            $("#upload_btn").click(function (event) {
                event.preventDefault();
                $(".upload_btn").prop('disabled', true)
                $(".upload_btn > .process_indicator").removeClass('off');
                if ($("#files_upload").prop('files').length === 0) {
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
                    url: uploadUrl,
                    data: form_data,
                    type: 'POST',
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                })
                    .done(function (data) {
                        $.unblockUI();
                        $("#upload_btn").prop('disabled', false)
                        $("#upload_btn > .process_indicator").removeClass('on');
                        if (data.status == 0) {
                            new PNotify({
                                title: 'Oops!',
                                text: 'An Error Occurred. Please try again.',
                                addclass: 'custom_notification',
                                type: 'error'
                            });
                        }
                        else {
                            new PNotify({
                                title: 'Success!',
                                text: data.message,
                                addclass: 'custom_notification',
                                type: 'success'
                            });
                        }
                    }).fail(function (error) {
                    $.unblockUI();
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
            $(".add_product_btn").on('click', function (e) {

                e.preventDefault();

                if (imageBag.length == 0) {
                    new PNotify({
                        title: 'Oops!',
                        text: 'No Image selected.',
                        addclass: 'custom_notification',
                        type: 'info'
                    });
                    return false;
                }

                $(".add_product_btn").prop('disabled', true)
                $(".add_product_btn > .process_indicator").removeClass('off');
                $("span.errorshow").html("")

                //Get product properties
                var properties = [];
                $.each($(".property_values select"), function (i, value) {
                    if ($(value).val() != "null") {
                        properties.push($(value).val())
                    }
                });


                $.ajax({
                    type: "POST",
                    url: "{!! route('create_products') !!}",
                    data: {
                        form_data: $("form#product_form").serialize(),
                        images: imageBag,
                        description: $(description_container).find('.ql-editor').html(),
                        properties: properties
                    }
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
                            $("input[name=" + key + "] + span.errorshow").html(item[0]).slideDown("slow")
                            $("select[name=" + key + "] + span.errorshow").html(item[0]).slideDown("slow")
                        });
                        new PNotify({
                            title: 'Oops!',
                            text: "Form validation error. <br>" + response.responseJSON.error,
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


        //Edit product properties
        $("#update_property_btn").on('click', function () {
            $("#update_property_btn").prop('disabled', true)
            $("#update_property_btn > .process_indicator").removeClass('off');
            updateProperties(productId)
        });

        $("#cancel_update_property_btn").on('click', function () {
            $("#update_property_btn").prop('disabled', false)
            $("#update_property_btn > .process_indicator").addClass('off');
        });

        function editProperty(id, name) {
            productId = id;
            $('#product_name').html($(name).data('product_name'))
            $('#property_edit_modal').modal('show')
        }

        function popImage(e) {
            $(e).parent().parent().fadeOut()
            imageBag = imageBag.filter(function (item) {
                return item != $(e).data('imgpath');
            })
        }

        function removeMedia(media) {
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
                        click: function (notice) {
                            $.ajax({
                                url: "{{route('media_remove')}}",
                                type: 'POST',
                                data: {mediaId: item.attr('id')}
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
                            click: function (notice) {
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

    </script>
@endpush
